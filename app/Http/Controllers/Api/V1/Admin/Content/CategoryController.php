<?php

namespace App\Http\Controllers\API\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CreatePostCategoryRequest;
use App\Http\Requests\Admin\Content\UpdatePostCategoryRequest;
// use App\Http\Resources\Admin\Content\PostCategoryCollection;
use App\Http\Resources\Admin\Content\PostCategoryResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\PostCategory;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

use function Laravel\Prompts\search;

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
              return PostCategoryResource::collection(PostCategory::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return PostCategoryResource::collection(PostCategory::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return PostCategoryResource::collection(PostCategory::with(['parent'])->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return PostCategoryResource::collection(PostCategory::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostCategoryRequest $request, ImageService $imageService)
    {

        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }

        $postCategory = PostCategory::create($inputs);

        if ($postCategory) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PostCategory $postCategory)
    {
          
          $postCategory =  new PostCategoryResource($postCategory);
         
          if ($postCategory) {
              return  response()->json(['status' => 200, 'data' => $postCategory]);
          } else {
              return response()->json(['status' => 404]);
          }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCategoryRequest $request,  ImageService $imageService, PostCategory $postCategory)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {

            if (!empty($postCategory->image)) {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }    else {
            if (asset($inputs['currentImage']) && !empty($postCategory->image)) {
                $image = $postCategory->image;
                $image['currentImage']   = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
         
        }
        $postCategory->update($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return response(['status' => 200]);
    }


    public function status(PostCategory $postCategory)
    {

        $postCategory->status =  $postCategory->status == 0 ? 1 : 0;
        $result = $postCategory->save();

        if ($result) {
            if ($postCategory->status == 0) {
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
        $parentId = PostCategory::where('parent_id', null)->get();
        if ($parentId) {
            return response()->json(['status' => 200, 'data' => $parentId]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
