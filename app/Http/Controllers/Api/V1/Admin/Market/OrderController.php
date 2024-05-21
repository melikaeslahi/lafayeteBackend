<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Market\OrderItemResource;
use App\Http\Resources\Admin\Market\OrderResource;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function newOrders($perPage = 0, $search = '')
    {
        $orders =  Order::where('order_status',  0)->get();
        foreach ($orders as $order) {

            $order->order_status = 1;
            $resault = $order->save();
        }
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('order_status', 0)->orderBy('created_at', 'desc')->get());
            }
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('order_status', 0)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->orderBy('created_at', 'desc')->where('order_status', 0)->paginate($paginate));;
        } else if ($paginate === null) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('order_status', 0)->orderBy('created_at', 'desc')->get());
        }
    }
    public function  all($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return OrderResource::collection(Order::with(['payment.paymentable', 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return OrderResource::collection(Order::with(['payment.paymentable' ,'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }
    public function sending($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return  OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('delivery_status', 1)->orderBy('created_at', 'desc')->get());
            }
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('delivery_status', 1)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->orderBy('created_at', 'desc')->where('delivery_status', 1)->paginate($paginate));
        } else if ($paginate === null) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('delivery_status', 1)->orderBy('created_at', 'desc')->get());
        }
    }
    public function unpaind($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('payment_status', 0)->orderBy('created_at', 'desc')->get());
            }
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('payment_status', 0)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->orderBy('created_at', 'desc')->where('payment_status', 0)->paginate($paginate));
        } else if ($paginate === null) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('payment_status', 0)->orderBy('created_at', 'desc')->get());
        }
    }
    public function canceled($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('order_status', 5)->orderBy('created_at', 'desc')->get());
            }
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('order_status', 5)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->orderBy('created_at', 'desc')->where('order_status', 5)->paginate($paginate));
        } else if ($paginate === null) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('order_status', 5)->orderBy('created_at', 'desc')->get());
        }
    }
    public function returned($perPage = 0, $search = '')
    {
        switch ($perPage && $search || $perPage) {
            case  $perPage == 0:
                $paginate = 20;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 1:
                $paginate = 30;
                $searchVal = $search ? $search : null;
                break;
            case  $perPage == 2:
                $paginate =  null;
                $searchVal = $search ? $search : null;
                break;
            default:
                $paginate =  20;
                break;
        }
        if ($paginate && $searchVal) {
            if ($paginate === null) {
                return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('payment_status', 3)->orderBy('created_at', 'desc')->get());
            }
            return  OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('payment_status', 3)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->orderBy('created_at', 'desc')->where('payment_status', 3)->paginate($paginate));
        } else if ($paginate === null) {
            return OrderResource::collection(Order::with(['payment.paymentable' , 'delivery'])->where('body', 'like',  '%' . $searchVal . '%')->where('payment_status', 3)->orderBy('created_at', 'desc')->get());
        }
    }
    public function changeSendStatus(Order $order)
    {
        switch ($order->delivery_status) {
            case 0:
                $order->delivery_status = 1;
                break;
            case 1:
                $order->delivery_status = 2;
                break;
            case 2:
                $order->delivery_status = 3;
                break;
            default:
                $order->delivery_status = 0;
        }
        $resault = $order->save();
        if ($resault) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function changeOrderStatus(Order $order)
    {
        switch ($order->order_status) {
            case 0:
                $order->order_status = 1;
                break;
            case 1:
                $order->order_status = 2;
                break;
            case 2:
                $order->order_status = 3;
                break;
            case 3:
                $order->order_status = 4;
                break;
            case 4:
                $order->order_status = 5;
                break;
            default:
                $order->order_status = 0;
        }
        $resault = $order->save();
        if ($resault) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function cancelOrder(Order $order)
    {
        $order->order_status = 5;
        $resault =  $order->save();
        if ($resault) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    
    public function show(Order $order)
    {
        if ($order) {
            return  response()->json(['status' => 200, 'data' => new  OrderResource($order->load(['delivery' , 'copan' , 'payment.paymentable' , 'address' , 'commonDiscount']))]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function  detailOrder($id)
    {
        $order =   OrderItemResource::collection(OrderItem::with(['singleProduct' , 'color' , 'orderItemsAttributes' , 'amazingSale'])-> where('order_id', $id)->get());
        if ($order) {
            return  response()->json(['status' => 200, 'data' => $order]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}