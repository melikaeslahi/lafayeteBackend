<?php

namespace App\Http\Controllers\Api\V1\Customer\Market;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Models\Admin\Comment;
use App\Models\Admin\Market\Compare;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product(Product $product)
    {
        
        $relatedProducts = Product::with('category' )->whereHas('category', function ($q) use ($product) {
            $q->where('id', $product->category->id);
        })->get()->except($product->id);
        if(Auth::check()){
            $isFavorite =  $product->user->contains(auth()->user()->id);
        }else{
            $isFavorite=false;
        }

        return  response()->json(['status'=>200 , 'product'=> new ProductResource($product->load(['metas' , 'colors' , 'brand' ,'category'  ,'images' , 'values'      ]  )), 'relatedProducts'=>$relatedProducts , 'isFavorite'=>$isFavorite ]);
    }

    public function addComment(Product $product , Request $request){
        $request->validate([
            'body' => 'required|max:2000'
        ]);
        $inputs = $request->all();
        $inputs['body'] = str_replace(PHP_EOL, '<br>', $request->body);
        $inputs['auther_id'] =  Auth::user()->id;
        $inputs['commentable_type'] =   Product::class;
        $inputs['commentable_id'] =   $product->id;
        $comment =  Comment::create($inputs);
         if($comment){
            return response()->json(['status' => 200]);
         }
    }

    public function addToFavorite(Product $product)
    { 
          if (Auth::check()) {
            $product->user()->toggle([Auth::user()->id]);
            if ($product->user->contains(Auth::user()->id)) {
                 
                return response()->json(['status' => 1 ]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }

    }
    public function addRate(Product $product, Request $request)
    {
        $productIds = auth()->user()->isUserPurchedProduct($product->id);

        if (Auth::check() && $productIds->count() > 0) {
            $user = Auth::user();
            $user->rate($product, $request->rating);
            return  response()->json(['status'=>200 , 
            'rateAvg'=> $product->ratingsAvg() ,
             'rateCount'=>$product->ratingsCount()]);
        } else {
            return   response()->json(['status'=>400]);
        }
    }
    public function addToCompare(Product $product)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->compare()->count() > 0) {
                $userCompareList = $user->compare;
            } else {
                $userCompareList =  Compare::create(['user_id' => $user->id]);
            }
            $product->compares()->toggle([$userCompareList->id]);
            if ($product->compares->contains($userCompareList->id)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }



}
