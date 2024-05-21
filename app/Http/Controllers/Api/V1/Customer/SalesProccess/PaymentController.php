<?php

namespace App\Http\Controllers\Api\V1\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\SalesProccess\CartItemResource;
use App\Http\Services\Payment\PaymentService;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\CashPayment;
use App\Models\Admin\Market\Copan;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\OnlinePayment;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\OrderItem;
use App\Models\Admin\Market\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment(){
        $cartItems =  CartItem::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();

        return response()->json(['status'=>200 , 'cartItems'=>  CartItemResource::collection($cartItems) , 'order' =>$order]);
    }

    public function copanDiscount(Request $request)
    {
        $request->validate([
            'copan' => 'required'
        ]);
        $copan =  Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();

        if ($copan != null) {


            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {

                    return redirect()->back()->withErrors([['copan' => 'کد وارد شده اشتباه است.']]);
                }
            }
            $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if ($order) {
                if ($copan->amount_type == 0) {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }
                } else {
                    $copanDiscountAmount = $copan->amount;
                }
                $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;
                $finalDiscount = $order->order_total_products_discount_amount +  $copanDiscountAmount;
                $order->update([
                    'copan_id' => $copan->id, 'order_copan_discount_amount' => $copanDiscountAmount,
                    'order_total_products_discount_amount' => $finalDiscount
                ]);
                return response()->json(['copan' => 'کد تخفیف وارد شده اعمال شد.']);
            } else {
                return    response()->json([['copan' => 'کد وارد شده اشتباه است.']]);
            }
        } else {
            return response()->json([['copan' => 'کد وارد شده اشتباه است.']]);
        }
    }

    public function paymentSubmit(Request $request,  PaymentService $paymentService)
    {
        $request->validate([
            'payment_type' => 'required'
        ]);
        $cartItems =  CartItem::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        $cash_receiver = null;
        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel =  OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel =  CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver :  ' ';

                break;
            default:
                return  response()->json(['error' => 'خطا']);
        }
        $paymented = $targetModel::create([
            'user_id' => auth()->user()->id,
            'amount' => $order->order_final_amount,
            'pay_date' => now(),
            'cash_receiver' => $cash_receiver,
            'status' => 1
        ]);

        $payment = Payment::create([
            'user_id' => auth()->user()->id,
            'amount' => $order->order_final_amount,
            'pay_date' => now(),
            'status' => 1,
            'type' => $type,
            'paymentable_id' => $paymented->id,
            'paymentable_type' => $targetModel,

        ]);
       

        if ($request->payment_type == 1) {

             $paymentService->zarinpal($order->order_final_amount, $order, $paymented);
        }
        $order->update([
                'order_status' => 3
            ]);
        foreach ($cartItems as   $cartItem) {
             OrderItem::create([
                'order_id'=>$order->id,
                'product_id'=> $cartItem->product_id,
                'product'=> $cartItem->product ,
                'amazing_sale_id'=> $cartItem->product->activeAmazingSales->id ?? null ,
                'amazing_sale_object'=>  $cartItem->product->activeAmazingSales ?? null  ,
                'amazing_sale_discount_amount'=> empty($cartItem->product->activeAmazingSales) ? 0 : $cartItem->cartItemProductPrice * ($cartItem->product->activeAmazingSales->percentage /100 ),
                'number'=> $cartItem->number,
                'final_product_price'=> empty($cartItem->product->activeAmazingSales) ? $cartItem->cartItemProductPrice : ($cartItem->cartItemProductPrice - $cartItem->cartItemProductPrice * ($cartItem->product->activeAmazingSales->percentage /100 )),
                'final_total_price'=>empty($cartItem->product->activeAmazingSales ) ? $cartItem->cartItemProductPrice * ($cartItem->number): ($cartItem->cartItemProductPrice - $cartItem->cartItemProductPrice * ($cartItem->product->activeAmazingSales->percentage /100 )) * ($cartItem->number),
                'color_id'=>$cartItem->color_id ,
       
            ]);
            $cartItem->delete();
        }
        return response()->json(['success' => 'سفارش شما ثبت شد.']);


    }
    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $paymentService)
    {
        $amount = $onlinePayment->amount * 10;
        $result = $this->zarinpalVerify($amount, $onlinePayment);
        $cartItems =  CartItem::where('user_id', Auth::user()->id)->get();
        if ($result['success']) {
            foreach ($cartItems as   $cartItem) {
                $cartItem->delete();
            }
            $order->update([
                'order_status' => 3
            ]);

            return  response()->json(['success' => 'پرداخت شما با موفقیت انجام شد.']);
        } else {
            $order->update([
                'order_status' => 2
            ]);
            return  response()->json(['danger' => 'سفارش شما با خطا مواجه شد.']);
        }
    }
}
