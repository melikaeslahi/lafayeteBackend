<?php

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\AdminUserRequest;
use App\Http\Resources\Admin\User\AdminUserResource;
use App\Http\Resources\Admin\User\PermissionResource;
use App\Http\Resources\Admin\User\RoleResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\User\Permission;
use App\Models\Admin\User\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
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
                return AdminUserResource::collection(User::with(['roles' , 'permissions'])->where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type', 1)->orderBy('created_at', 'desc')->get());
            }
            return  AdminUserResource::collection(User::with(['roles' , 'permissions'])->where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type', 1)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return AdminUserResource::collection(User::with(['roles' , 'permissions'])->where('user_type', 1)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return AdminUserResource::collection(User::with(['roles' , 'permissions'])->where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type', 1)->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminUserRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $resault = $imageService->save($request->file('profile_photo_path'));
            if ($resault === false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['profile_photo_path'] = $resault;
        }
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 1;
        $admin = User::create($inputs);
        if ($admin) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        if ($admin) {
            return  response()->json(['status' => 200, 'data' => new AdminUserResource($admin)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUserRequest $request, User $admin, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            if (!empty($admin->profile_photo_path)) {
                $imageService->deleteImage($admin->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $resault = $imageService->save($request->file('profile_photo_path'));
            if ($resault === false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['profile_photo_path'] = $resault;
        }
        $admin = $admin->update($inputs);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->forceDelete();
        return response(['status' => 200]);
    }
    public function status(User $admin)
    {
        $admin->status =  $admin->status == 0 ? 1 : 0;
        $result = $admin->save();

        if ($result) {
            if ($admin->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
    public function activation(User  $admin)
    {
        $admin->activation =  $admin->activation == 0 ? 1 : 0;
        $result = $admin->save();

        if ($result) {
            if ($admin->activation == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
    public function roles(User $admin)
    {
        $roles =  Role::all();
        if ($roles) {
            return  response()->json(['status' => 200, 'roles' =>   RoleResource::collection($roles), 'admin' => new AdminUserResource($admin) ]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function rolesStore(Request $request,  User $admin)
    {
        $validated = $request->validate([
            'roles' => 'required|exists:roles,id|array'
        ]);
        $rolesIds =  explode(',', $request->roles[0]);
        $roles =  $admin->roles()->sync($rolesIds);
        if ($roles) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function  permissions(User $admin)
    {
        $permissions =  Permission::all();
        if ($permissions) {
            return  response()->json(['status' => 200, 'permissions' =>   PermissionResource::collection($permissions), 'admin' => new AdminUserResource($admin)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    public function permissionsStore(Request $request,  User $admin)
    {
        $validated = $request->validate([
            'permissions' => 'required|exists:permissions,id|array'
        ]);
        $permissionsIds =  explode(',', $request->permissions[0]);
        $permissions = $admin->permissions()->sync($permissionsIds);
        if ($permissions) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
