<?php

namespace App\Http\Controllers\Api\V1\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\ProfileRequest;
use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function  update(ProfileRequest $request , ImageService $imageService){
        $inputs=$request->all();

        $user=auth()->user();
       
        if ($request->hasFile('profile_photo_path')) {
         if (!empty($user->profile_photo_path)) {
             $imageService->deleteImage($user->profile_photo_path);
         }
         $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
         $resault = $imageService->save($request->file('profile_photo_path'));
         if ($resault === false) {
             return response()->json(['status' => 'تصویری دریافت نشد']);
         }
         $inputs['profile_photo_path'] = $resault;
     }
       
        $user->update($inputs);
        return response()->json(['status'=> 200 , 'user' =>$user]);
   }
}
