<?php

namespace App\Http\Controllers\Api\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\BannerStoreRequest;
use App\Http\Requests\Admin\Content\BannerUpdateRequest;
use App\Http\Resources\Admin\Content\BannerResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
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
              return BannerResource::collection(Banner::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            $banner =  BannerResource::collection(Banner::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
            if ($banner) {
                return $banner;
            } else {
                return response(['status' => 404]);
            }
        }
        else if($paginate){
            return BannerResource::collection(Banner::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return BannerResource::collection(Banner::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerStoreRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }

        $postCategory =  Banner::create($inputs);

        if ($postCategory) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {   
        if($banner){
            return  response()->json(['status'=> 200 , 'data' => new BannerResource($banner)]);
        }else{
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerUpdateRequest $request, Banner $banner, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {

            if (!empty($banner->image)) {
                $imageService->deleteImage($banner->image['directory']);
            }   
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        } else   {
            if (asset($inputs['currentImage']) && !empty($banner->image)) {
                $image = $banner->image;
                $image['currentImage']   = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }

        $banner->update($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return response(['status' => 200]);
    }

    public function status(Banner $banner)
    {
        $banner->status =  $banner->status == 0 ? 1 : 0;
        $result = $banner->save();

        if ($result) {
            if ($banner->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
    public function position()
    {
        $positions = Banner::$position;
        if ($positions) {
            return response()->json(['status'=>200 , 'positions'=>$positions ]);
        }else {
            return response()->json(['status'=>404]);
        
        }
    }
 
}
