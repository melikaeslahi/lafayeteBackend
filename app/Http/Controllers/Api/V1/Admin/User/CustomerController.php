<?php

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CustomerRequest;
use App\Http\Resources\Admin\User\CustomerResource;
use App\Http\Services\Image\ImageService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
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
                return CustomerResource::collection(User::where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type', 0)->orderBy('created_at', 'desc')->get());
            }
            return CustomerResource::collection(User::where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type', 0)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return CustomerResource::collection(User::where('user_type', 0)->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return CustomerResource::collection(User::where('first_name', 'like',  '%' . $searchVal . '%')->where('user_type', 0)->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request,  ImageService $imageService)
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
        $inputs['user_type'] = 0;
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
    public function show(User $user)
    {
        if ($user) {
            return  response()->json(['status' => 200, 'data' => new  CustomerResource($user)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, User $customer, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            if (!empty($customer->profile_photo_path)) {
                $imageService->deleteImage($customer->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $resault = $imageService->save($request->file('profile_photo_path'));
            if ($resault === false) {
                return response()->json(['status' => 'تصویری دریافت نشد']);
            }
            $inputs['profile_photo_path'] = $resault;
        }
        $admin = $customer->update($inputs);
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(User $customer)
    {
        $customer->forceDelete();
        return response(['status' => 200]);
    }
    
    public function status(User $customer)
    {
        $customer->status =  $customer->status == 0 ? 1 : 0;
        $result = $customer->save();
        if ($result) {
            if ($customer->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function activation(User  $customer)
    {
        $customer->activation =  $customer->activation == 0 ? 1 : 0;
        $result = $customer->save();
        if ($result) {
            if ($customer->activation == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
