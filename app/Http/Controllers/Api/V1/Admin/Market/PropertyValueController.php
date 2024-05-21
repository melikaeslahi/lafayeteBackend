<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\PropertyValueStoreRequest;
use App\Http\Resources\Admin\Market\CategoryValueResource;
use App\Http\Resources\Admin\Market\PropertyValueResource;
use App\Models\Admin\Market\CategoryAttribute;
use App\Models\Admin\Market\CategoryValue;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;

class PropertyValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage = 0 , CategoryAttribute $categoryAttribute)
    {
         

            if ($perPage == 0) {
                return  CategoryValueResource::collection(CategoryValue::where('category_attribute_id' , $categoryAttribute->id)->orderBy('created_at', 'desc')->paginate(20));
            } else if ($perPage == 1) {

                return CategoryValueResource::collection(CategoryValue::where('category_attribute_id' , $categoryAttribute->id)->orderBy('created_at', 'desc')->paginate(30));
            } else if ($perPage == 2) {

                return CategoryValueResource::collection(CategoryValue::where('category_attribute_id' , $categoryAttribute->id)->orderBy('created_at', 'desc')->get());
            }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyValueStoreRequest $request , CategoryAttribute $categoryAttribute)
    {
        $inputs = $request->all(); 
        $inputs['value']= json_encode(['value' => $request->value , 'price_increase'=>$request->price_increase]);
        $inputs['category_attribute_id']=$categoryAttribute->id;
        $categoryValue =   CategoryValue::create($inputs);
        if ($categoryValue) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryValue $categoryValue)
    {
           if ($categoryValue) {
               return  response()->json(['status' => 200, 'data' =>  new CategoryValueResource($categoryValue)]);
           } else {
               return response()->json(['status' => 404]);
           }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyValueStoreRequest $request,  CategoryAttribute $categoryAttribute , CategoryValue $categoryValue)
    {
        $inputs = $request->all(); 
        $inputs['value']= json_encode(['value' => $request->value , 'price_increase'=>$request->price_increase]);
        $inputs['category_attribute_id']=$categoryAttribute->id;
        $value =   $categoryValue->update($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryValue $categoryValue)
    {
        $categoryValue->delete();
        return response(['status' => 200]);
    }
    

    public function productsAndAttributes(){
        $products =  Product::all();
        $attributes =  CategoryAttribute::all();
        if($products && $attributes ){
            return response()->json(['status'=>200 , 'products' =>$products , 'attributes' =>$attributes ]);
          }else{
            return response()->json(['status'=>404 ]);
            
          }
    }
}
