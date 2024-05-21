<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\BrandStoreRequest;
use App\Http\Requests\Admin\Market\BrandUpdateRequest;
use App\Http\Resources\Admin\Market\BrandResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Market\Brand;
 

class BrandController extends Controller
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
              return BrandResource::collection(Brand::where('persian_name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return BrandResource::collection(Brand::where('persian_name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return BrandResource::collection(Brand::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return BrandResource::collection(Brand::where('persian_name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request , ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brands');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['logo'] = $result;
        }
        $brand =  Brand::create($inputs);
        if ($brand) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
          if ($brand) {
              return  response()->json(['status' => 200, 'data' => new BrandResource($brand)]);
          } else {
              return response()->json(['status' => 404]);
          }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, Brand $brand , ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {

            if (!empty($brand->logo)) {
                $imageService->deleteDirectoryAndFiles($brand->logo['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['logo'] = $result;
        } else if (asset($inputs['currentImage']) && !empty($brand->logo)) {
            $image = $brand->logo;
            $image['currentImage']   = $inputs['currentImage'];
            $inputs['logo'] = $image;
        }
        $brand->update($inputs);
        return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response(['status' => 200]);
    }
    public function status(Brand $brand)
    {
        $brand->status =  $brand->status == 0 ? 1 : 0;
        $result = $brand->save();
        if ($result) {
            if ($brand->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
