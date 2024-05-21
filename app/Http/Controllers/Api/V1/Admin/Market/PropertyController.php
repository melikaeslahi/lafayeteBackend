<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\PropertyStoreRequest;
use App\Http\Resources\Admin\Market\CategoryAttributeResource;
use App\Http\Resources\Admin\Market\PropertyResource;
use App\Models\Admin\Market\CategoryAttribute;
use App\Models\Admin\Market\ProductCategory;
use Illuminate\Http\Request;

class PropertyController extends Controller
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
              return CategoryAttributeResource::collection(CategoryAttribute::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return CategoryAttributeResource::collection(CategoryAttribute::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return CategoryAttributeResource::collection(CategoryAttribute::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return CategoryAttributeResource::collection(CategoryAttribute::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyStoreRequest $request )
    {
        $inputs = $request->all();
         

        $productCategory =  CategoryAttribute::create($inputs);
        if ($productCategory) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryAttribute $categoryAttribute)
    {
      if ($categoryAttribute) {
          return  response()->json(['status' => 200, 'data' => new CategoryAttributeResource($categoryAttribute)]);
      } else {
          return response()->json(['status' => 404]);
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyStoreRequest $request,  CategoryAttribute $categoryAttribute)
    {
        $inputs = $request->all();
        $categoryAttribute->update($inputs);

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAttribute $categoryAttribute)
    {
        
        $categoryAttribute->delete();
        return response(['status' => 200]);
    }
    public function category(){
        $categories =  ProductCategory::all();
     
        if($categories){
            return response()->json(['status'=>200 , 'categories' =>$categories ]);
          }else{
            return response()->json(['status'=>404 ]);
            
          }
    }
    
}
