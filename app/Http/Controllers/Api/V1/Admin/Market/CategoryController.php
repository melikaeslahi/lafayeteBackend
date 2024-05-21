<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Resources\Admin\Market\ProductCategoryResource;
use App\Models\Admin\Market\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\Market\ProductCategoryUpdateRequest;
use App\Http\Services\Image\ImageService;
 

class CategoryController extends Controller
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
              return ProductCategoryResource::collection(ProductCategory::with('parent')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return ProductCategoryResource::collection(ProductCategory::with('parent')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return ProductCategoryResource::collection(ProductCategory::with('parent')->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return ProductCategoryResource::collection(ProductCategory::with('parent')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryStoreRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }

        $productCategory =  ProductCategory::create($inputs);
        if ($productCategory) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
   
          if ($productCategory) {
              return  response()->json(['status' => 200, 'data' => new ProductCategoryResource($productCategory)]);
          } else {
              return response()->json(['status' => 404]);
          }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {

            if (!empty($productCategory->image)) {
                $imageService->deleteDirectoryAndFiles($productCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        } else if (asset($inputs['currentImage']) && !empty($productCategory->image)) {
            $image = $productCategory->image;
            $image['currentImage']   = $inputs['currentImage'];
            $inputs['image'] = $image;
        }

        $productCategory->update($inputs);

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {

        $productCategory->delete();
        return response(['status' => 200]);
    }

    public function status(ProductCategory $productCategory)
    {

        $productCategory->status =  $productCategory->status == 0 ? 1 : 0;
        $result = $productCategory->save();

        if ($result) {
            if ($productCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }

    public function  showInMenu(ProductCategory $productCategory)
    {

        $productCategory->show_in_menu =  $productCategory->show_in_menu == 0 ? 1 : 0;
        $result = $productCategory->save();

        if ($result) {
            if ($productCategory->show_in_menu == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
    public function parentId()
    {

        $parentId = ProductCategory::where('parent_id', null)->get();
        if ($parentId) {
            return response()->json(['status' => 200, 'data' => $parentId]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
