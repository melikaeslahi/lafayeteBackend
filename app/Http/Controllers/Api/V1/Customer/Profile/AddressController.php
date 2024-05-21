<?php

namespace App\Http\Controllers\Api\V1\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(){
        $province = Province::all();
        return response()->json(['status' =>200 , 'province' =>$province]);
    }
}
