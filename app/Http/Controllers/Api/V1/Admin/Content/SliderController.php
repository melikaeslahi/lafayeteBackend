<?php

namespace App\Http\Controllers\Api\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ProductsSliderRequest;
use App\Http\Requests\Admin\Content\SliderRequest;
use App\Http\Resources\Admin\Content\SliderResource;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Models\Admin\Content\Slider;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;

class SliderController extends Controller
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
                return SliderResource::collection(Slider::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return SliderResource::collection(Slider::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return SliderResource::collection(Slider::with(['parent'])->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return SliderResource::collection(Slider::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $inputs = $request->all();
        $slider =  Slider::create($inputs);
        if ($slider) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        if ($slider) {
            return  response()->json(['status' => 200, 'data' =>  new SliderResource($slider)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $inputs = $request->all();
        $slider->update($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return response(['status' => 200]);
    }

    public function status(Slider $slider)
    {
        $slider->status =  $slider->status == 0 ? 1 : 0;
        $result = $slider->save();
        if ($result) {
            if ($slider->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }

    public function products(Slider $slider)
    {
        $products =   Product::all();
        if ($products) {
            return  response()->json(['status' => 200, 'products' =>    ProductResource::collection($products), 'slider' => new SliderResource($slider)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function productsStore(ProductsSliderRequest $request, Slider $slider)
    {
        $productsIds =  explode(',', $request->products[0]);
        $products =  $slider->products()->sync($productsIds);
        if ($products) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function parentId()
    {
        $parentId =  Slider::where('parent_id', null)->get();
        if ($parentId) {
            return response()->json(['status' => 200, 'data' =>  $parentId]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
