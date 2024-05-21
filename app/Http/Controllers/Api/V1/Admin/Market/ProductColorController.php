<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductColorStoreRequest;
use App\Http\Resources\Admin\Market\ProductColorResource;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage = 0 , Product $product, $search = '' )
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
              return ProductColorResource::collection(ProductColor::with('product')->where('color_name', 'like',  '%' . $searchVal . '%')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->get());
            }
          return ProductColorResource::collection( ProductColor::with('product')->where('color_name', 'like',  '%' . $searchVal . '%')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return ProductColorResource::collection(ProductColor::with('product')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return  ProductColorResource::collection(ProductColor::with('product')->where('color_name', 'like',  '%' . $searchVal . '%')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductColorStoreRequest $request , product $product )
    {
        $inputs = $request->all();
        
        $inputs['product_id']=$product->id ;
        $color =    ProductColor::create($inputs);
        if ($color) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductColor $productColor)
    {
        $productColor->delete();
        return response(['status' => 200]);
    }
}
