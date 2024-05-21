<?php

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\PermissionRequest;
use App\Http\Resources\Admin\User\PermissionResource;
use App\Models\Admin\User\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
              return PermissionResource::collection(Permission::with('roles')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return PermissionResource::collection(Permission::with('roles')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));   
        }
        else if($paginate){
            return PermissionResource::collection(Permission::with('roles')->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return PermissionResource::collection(Permission::with('roles')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $inputs = $request->all();
        $permission = Permission::create($inputs);
        if ($permission) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        if ($permission) {
            return  response()->json(['status' => 200, 'data' => new PermissionResource($permission)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update( PermissionRequest $request,  Permission $permission )
    {
       $inputs = $request->all();
       $permission = $permission->update($inputs);
       return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
       return response()->json(['status' => 200]);

    }
}
