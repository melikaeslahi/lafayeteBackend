<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\StoreRequest;
use App\Http\Requests\Admin\Market\StoreUpdateRequest;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage = 0, $search = '')
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
              return ProductResource::collection(Product::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return ProductResource::collection(Product::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return ProductResource::collection(Product::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return ProductResource::collection(Product::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request , Product $product)
    {
        $product->marketable_number += $request->marketable_number;
          $store=  $product->save();
         Log::info(" receiver => {{$request->receiver}} , deliverer => {{$request->deliverer}} , description=>{{$request->description}} , add=>{{$request->marketable_number}} ");
         if ($store) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
         if ($product) {
             return  response()->json(['status' => 200, 'data' =>  new ProductResource($product)]);
         } else {
             return response()->json(['status' => 404]);
         }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request,  Product $product)
    {
        $inputs=$request->all();
        $product->update($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
