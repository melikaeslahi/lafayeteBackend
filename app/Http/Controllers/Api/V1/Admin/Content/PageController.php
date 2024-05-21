<?php

namespace App\Http\Controllers\Api\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PageStoreRequest;
use App\Http\Requests\Admin\Content\PageUpdateRequest;
use App\Http\Resources\Admin\Content\PageResource;
use App\Models\Admin\Content\Page;
use Illuminate\Http\Request;

class PageController extends Controller
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
              return PageResource::collection(Page::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return  PageResource::collection(Page::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));   
        }
        else if($paginate){
            return PageResource::collection(Page::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return PageResource::collection(Page::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    public function store(PageStoreRequest  $request)
    {
        $inputs= $request->all();
        $page =  Page::create($inputs);
        if ($page) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    { 
          if ($page) {
              return  response()->json(['status' => 200, 'data' => new PageResource($page)]);
          } else {
              return response()->json(['status' => 404]);
          }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request,  Page $page)
    {
        $inputs = $request->all();
        $page->update($inputs);

        return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(['status'=>200]);
    }
    public function status(Page $page)
    {
        $page->status =  $page->status == 0 ? 1 : 0;
        $result = $page->save();

        if ($result) {
            if ($page->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
}