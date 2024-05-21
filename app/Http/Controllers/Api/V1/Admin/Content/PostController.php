<?php

namespace App\Http\Controllers\Api\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostStoreRequest;
use App\Http\Requests\Admin\Content\PostUpdateRequest;
use App\Http\Resources\Admin\Content\PostResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\Post;
use App\Models\Admin\Content\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
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
              return PostResource::collection(Post::with(['postCategory'])->where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return PostResource::collection(Post::with(['postCategory'])->where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return PostResource::collection(Post::with(['postCategory'])->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return PostResource::collection(Post::with(['postCategory'])->where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        $realTimestampStart=substr($request->published_at , 0 , 10);
        $inputs['published_at']=date('Y-m-d H:i:s' ,(int)$realTimestampStart);
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'posts');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result ===  false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['image'] = $result;
        }
        $inputs['author_id'] = 1;
        $posts =  Post::create($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
 
        if($post){
            return  response()->json(['status'=> 200 , 'data' =>new PostResource($post)]);
        }else{
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( PostUpdateRequest $request, Post $post , ImageService $imageService )
    {
        $inputs = $request->all();
        $realTimestampStart=substr($request->published_at , 0 , 10);
        $inputs['published_at']=date('Y-m-d H:i:s' ,(int)$realTimestampStart);
        if ($request->hasFile('image')) {
             
         if (!empty($post->image)) {
             $imageService->deleteDirectoryAndFiles($post->image['directory']);
         }
         $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'posts');
         $result =$imageService->createIndexAndSave($request->file('image'));
         if ($result ===  false) {
             return response()->json(['status' => 'تصویری دریافت نشد']);
             }
        $inputs['image'] = $result;
        }
        else if (asset($inputs['currentImage']) && !empty($post->image) ) {
              $image = $post->image;
              $image['currentImage']   = $inputs['currentImage'];
              $inputs['image'] = $image;
          }
        
        $post->update($inputs);
 
       return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response(['status' => 200]);
    }

    public function status(Post  $post)
    {

        $post->status =  $post->status == 0 ? 1 : 0;
        $result = $post->save();

        if ($result) {
            if ($post->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }

    public function commentable(Post $post)
    {

        $post->commentable =  $post->commentable == 0 ? 1 : 0;
        $result = $post->save();

        if ($result) {
            if ($post->commentable == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
 
    public function  category(){
       
        $category=   PostCategory::all() ;
        if($category){
          return response()->json(['status'=>200 , 'data' =>$category]);
        }else{
          return response()->json(['status'=>404 ]);
          
        }
       
  
  }

}
