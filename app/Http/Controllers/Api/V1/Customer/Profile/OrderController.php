<?php

namespace App\Http\Controllers\Api\V1\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Market\OrderResource;
use App\Models\Admin\Market\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        if(isset(request()->type)){
            $orders = auth()->user()->orders()->where('order_status' , request()->type)->orderBy('id' , 'desc')->get();
        }else{
            $orders = auth()->user()->orders()->orderBy('id' , 'desc')->get();
        }
        return response()->json(['status'=> 200 , 'orders' =>   OrderResource::collection($orders->load(['delivery' , 'orderItems.singleProduct'   , 'address' ]) ) ]);
    }

     public function details(Order $order){
        return response()->json(['status'=> 200 , 'orders' =>  new OrderResource($order->load(['delivery' , 'orderItems.singleProduct' , 'orderItems.color' , 'copan' , 'payment.paymentable' , 'address' , 'commonDiscount']) ) ]);
    }

    public function  show(Order $order){
        return response()->json(['status'=> 200 , 'orders' => new  OrderResource($order->load([ 'orderItems.singleProduct' , 'orderItems.orderItemsAttributes'  , 'address'  ]) ) ]);
    }
}
