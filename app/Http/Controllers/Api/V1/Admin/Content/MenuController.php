<?php

namespace App\Http\Controllers\Api\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\MenuStoreRequest;
use App\Http\Requests\Admin\Content\MenuUpdateRequest;
use App\Http\Resources\Admin\Content\MenuResource; 
use App\Models\Admin\Content\Menu;


class MenuController extends Controller
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
              return MenuResource::collection(Menu::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
         return   MenuResource::collection(Menu::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return MenuResource::collection(Menu::with(['parent'])->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return MenuResource::collection(Menu::with(['parent'])->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreRequest $request)
    {
        $inputs = $request->all();

        $menu =  Menu::create($inputs);

        if ($menu) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        if($menu){
            return  response()->json(['status'=> 200 , 'data' => new MenuResource($menu)]);
        }else{
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuUpdateRequest $request,  Menu $menu)
    {
        $inputs = $request->all();
        $menu->update($inputs);

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response(['status' => 200]);
    }

    public function status(Menu $menu)
    {

        $menu->status =  $menu->status == 0 ? 1 : 0;
        $result = $menu->save();

        if ($result) {
            if ($menu->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
   
    public function parentId(){
        $parentId=  Menu::where('parent_id'  , null)->get();
        if($parentId){
          return response()->json(['status'=>200 , 'data' =>$parentId]);
        }else{
          return response()->json(['status'=>404 ]);
          
        }
  }

}
