<?php

namespace App\Http\Controllers\Api\V1\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Http\Resources\Customer\SalesProccess\CartItemResource;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function cart()
    {
        if ( Auth::check()) {
            $cartItems =  CartItem::where('user_id', Auth::user()->id)->get();
            if ($cartItems->count() >0) {
                $relatedProducts = Product::all();
                return  response()->json(['status' => 200 , 
                'relatedProducts'=>ProductResource::collection($relatedProducts) ,
                 'cartItems'=>  CartItemResource::collection($cartItems->load(['product' , 'color']))]);
            }else {
                 return response()->json(['status' => 200]);
            }
           
        } else {
            return response()->json(['status' => 200 , 'message'=>'not login user']);
        }
    }

    public function updateCart(Request $request)
    {
      $inputs= $request->all();
       $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
       foreach ($cartItems as $cartItem) {
        if ( isset($inputs['number'][$cartItem->id])) {
           $cartItem->update(['number'=>$inputs['number'][$cartItem->id]  ]);
        }
       }
       return response()->json(['status' => 200]);
    
        
    }

    public function addToCart(Product $product, Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'color_id' => 'nullable|exists:product_colors,id',
              
                'number' => 'numeric|min:1, max:5',
            ]);
            $cartItems = CartItem::where('product_id', $product->id)->where('user_id',  auth()->user()->id)->get();
            if (!isset($request->color_id)) {
                $request->color = null;
            }
            
            foreach ($cartItems as $cartItem) {
                if ($cartItem->color_id == $request->color_id) {
                    if ($cartItem->number != $request->number) {
                        $cartItem->update(['number' => $request->number]);
                    }
                    return  response()->json(['status' => 200]);
                }
            }
            $inputs = [];
            $inputs['color_id'] = $request->color_id;
            $inputs['user_id'] = auth()->user()->id;
            $inputs['product_id'] =  $product->id;
            CartItem::create($inputs);
            return response()->json(['status' => 200]);;
        } else {
            return response()->json(['status' => 404]);;
        }
    }

    public function removeFromCart(CartItem $cartItem)
    {
      
        if ( $cartItem->user_id == Auth::user()->id) {
           $cartItem->delete();
        }
        return response()->json(['status' => 200]);
    }
}
