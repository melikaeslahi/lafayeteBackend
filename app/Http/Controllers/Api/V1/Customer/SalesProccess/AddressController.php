<?php

namespace App\Http\Controllers\Api\V1\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProccess\ChooseAddressAndDeliveryRequest;
use App\Http\Requests\Customer\SalesProccess\StoreAddressRequest;
use App\Http\Requests\Customer\SalesProccess\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\CommonDiscount;
use App\Models\Admin\Market\Delivery;
use App\Models\Admin\Market\Order;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
  public function addressAndDelivery()
  {
    $user =  Auth::user();
    $cartItems =  CartItem::where('user_id', Auth::user()->id)->get();
    $addresses =   Address::where('user_id', Auth::user()->id)->get();

    $deliveryMethods = Delivery::where('status', 1)->get();

    $provinces = Province::all();

    if (empty(CartItem::where('user_id', $user->id)->count())) {
      return  response()->json(['status' => 404, 'message' => 'cartItem is empty']);
    }

    return  response()->json([
      'status' => 200,
      'cartItems' => $cartItems,
      'addresses' => $addresses,
      'provinces' => $provinces,
      'deliveryMethods' => $deliveryMethods
    ]);
  }

  public function addAddress(StoreAddressRequest $request)
  {

    $inputs = $request->all();

    $inputs['user_id'] = auth()->user()->id;
    $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
    $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
    $address =  Address::create($inputs);
    if ($address) {
      return response()->json(['status' => 200]);
    } else {
      return response()->json(['status' => 404]);
    }
  }

  public function updateAddress(Address $address, UpdateAddressRequest $request)
  {
    $inputs = $request->all();
    $inputs['user_id'] = auth()->user()->id;
    $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
    $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);

    $updateAddress = $address->update($inputs);

    return response()->json(['status' => 200]);
  }

  public function  getCities(Province $province)
  {
    $cities = $province->cities;
    if ($cities != null) {
      return response()->json(['status' => true, 'cities' => $cities]);
    } else {
      return response()->json(['status' => false, 'cities' => null]);
    }
  }
  public function chooseAddressAndDelivery(ChooseAddressAndDeliveryRequest  $request)
  {
    $user = Auth::user();
    $cartItems = CartItem::where('user_id', $user->id)->get();
    $delivery=Delivery::where('id' , $request->delivery_id)->first();
    $deliveryAmount= $delivery->amount;
    $totalProductPrice = 0;
    $totalDiscount = 0;
    $totalFinalPrice = 0;
    $totalFinalDiscountPriceWithNumber = 0;

    foreach ($cartItems as $cartItem) {
      $totalProductPrice += $cartItem->cartItemProductPrice;
      $totalDiscount += $cartItem->cartItemProductDiscount;
      $totalFinalPrice += $cartItem->cartItemFinalPrice + $deliveryAmount;
      $totalFinalDiscountPriceWithNumber += $cartItem->cartItemFinalDiscount;
    }
    // common discount
    $commonDiscount =  CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();


    if ($commonDiscount) {

      $inputs['common_discount_id'] = $commonDiscount->id;
      $commonPercentageDiscountAmount = $totalFinalPrice * ($commonDiscount->percentage / 100);


      if ($commonPercentageDiscountAmount > $commonDiscount->discount_ceiling) {

        $commonPercentageDiscountAmount = $commonDiscount->discount_ceiling;
      }
      if ($commonDiscount != null and $totalFinalPrice >= $commonDiscount->minimal_order_amount  ) {
        $finalPrice = $totalFinalPrice - $commonPercentageDiscountAmount ;
      } else {
        $finalPrice = $totalFinalPrice  ;
      }
    } else {
      $commonPercentageDiscountAmount = null;
      $finalPrice = $totalFinalPrice;
    }

    $inputs = $request->all();
    $inputs['user_id'] = $user->id;
    $inputs['order_final_amount'] = $finalPrice;
    $inputs['delivery_amount'] = $delivery->amount;
    $inputs['order_discount_amount'] = $totalFinalDiscountPriceWithNumber;
    $inputs['order_common_discount_amount'] = $commonPercentageDiscountAmount;
    $inputs['order_total_products_discount_amount'] = $inputs['order_discount_amount'] + $inputs['order_common_discount_amount'];


    $order =  Order::updateOrCreate(
      ['user_id' => $user->id, 'order_status' => 0],
      $inputs
    );
    return  response()->json(['status' => 200]);
  }
}
