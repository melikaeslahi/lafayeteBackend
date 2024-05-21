<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductSizeRequest;
use App\Http\Resources\Admin\Market\ProductSizeResource;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    public function index($perPage = 0 ,  Product $product, $search = '' )
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
              return  ProductSizeResource::collection(ProductSize::with('product')->where('color_name', 'like',  '%' . $searchVal . '%')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->get());
            }
          return ProductSizeResource::collection( ProductSize::with('product')->where('color_name', 'like',  '%' . $searchVal . '%')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return ProductSizeResource::collection(ProductSize::with('product')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return  ProductSizeResource::collection(ProductSize::with('product')->where('color_name', 'like',  '%' . $searchVal . '%')->where('product_id' , $product->id )->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSizeRequest $request , product $product )
    {
        $inputs = $request->all();
        
        $inputs['product_id']=$product->id ;
        $color =    ProductSize::create($inputs);
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
    public function destroy(ProductSize $productSize)
    {
        $productSize->delete();
        return response(['status' => 200]);
    }
}
