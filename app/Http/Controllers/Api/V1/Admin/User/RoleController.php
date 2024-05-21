<?php

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RoleRequest;
use App\Http\Resources\Admin\User\RoleResource;
use App\Models\Admin\User\Permission;
use App\Models\Admin\User\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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
              return RoleResource::collection(Role::with('permissions')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return RoleResource::collection(Role::with('permissions')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return RoleResource::collection(Role::with('permissions')->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return RoleResource::collection(Role::with('permissions')->where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store( RoleRequest $request)
    {
        $inputs = $request->all();
        $role =  Role::create($inputs);
        if ($role) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }

    }
    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
          if ($role) {
              return  response()->json(['status' => 200, 'data' => new RoleResource($role)]);
          } else {
              return response()->json(['status' => 404]);
          }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(  RoleRequest $request,   Role $role )
    {
       $inputs = $request->all();
       $role = $role->update($inputs);
       return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
       return response()->json(['status' => 200]);
    }
}
