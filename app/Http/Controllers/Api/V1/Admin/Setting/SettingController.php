<?php

namespace App\Http\Controllers\Api\V1\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Http\Resources\Admin\Setting\SettingResource;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Setting\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage = 0, $search = '')
    {
        $setting =  Setting::first();
        if ($setting === null) {
            $default = new  SettingSeeder();
            $default->run();
            $setting = Setting::first();
        }

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
                return SettingResource::collection(Setting::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
            return SettingResource::collection(Setting::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return SettingResource::collection(Setting::orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return SettingResource::collection(Setting::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        if ($setting) {
            return  response()->json(['status' => 200, 'data' => new SettingResource($setting)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( SettingRequest $request,  Setting $setting, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('logo')) {

            if (!empty($setting->logo)) {
                $imageService->deleteImage($setting->logo);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('logo');
            $resault = $imageService->save($request->file('logo'));
            if ($resault === false) {
                return redirect()->route('admin.setting.index')->with('swal-error', 'تصویر آپلود نشد.');
            }
            $inputs['logo'] = $resault;
        }


        if ($request->hasFile('icon')) {

            if (!empty($setting->icon)) {
                $imageService->deleteImage($setting->logo);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('icon');
            $resault = $imageService->save($request->file('icon'));
            if ($resault === false) {
                return redirect()->route('admin.setting.index')->with('swal-error', 'تصویر آپلود نشد.');
            }

            $inputs['icon'] = $resault;
        }


        $setting->update($inputs);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
}
