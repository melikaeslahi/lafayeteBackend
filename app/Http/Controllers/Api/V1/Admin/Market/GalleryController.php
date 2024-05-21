<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\GalleryStoreRequest;
use App\Http\Resources\Admin\Market\GalleryResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Market\Gallery;
use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage = 0   , Product $product)
    {
            if ($perPage == 0) {
                return GalleryResource::collection(Gallery::where('product_id',  $product->id )->orderBy('created_at', 'desc')->paginate(20));
            } else if ($perPage == 1) {

                return GalleryResource::collection(Gallery::where('product_id',  $product->id )->orderBy('created_at', 'desc')->paginate(30));
            } else if ($perPage == 2) {

                return GalleryResource::collection(Gallery::where('product_id',  $product->id )->orderBy('created_at', 'desc')->get());
            }    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryStoreRequest $request , Product $product , ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-gallery');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }
        $inputs['product_id']=$product->id ;
        $gallery =   Gallery::create($inputs);
        if ($gallery) {
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
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response(['status' => 200]);
    }
}
