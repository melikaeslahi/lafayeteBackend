<?php

namespace App\Http\Controllers\Api\V1\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\SMSRequest;
use App\Http\Resources\Admin\Notify\SMSResource;
use App\Models\Admin\Notify\Email;
use App\Models\Admin\Notify\SMS;
use Illuminate\Http\Request;

class SMSController extends Controller
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
              return SMSResource::collection(SMS::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return SMSResource::collection(SMS::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return SMSResource::collection(SMS::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return SMSResource::collection(SMS::where('title', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $realTimestampStart=substr($request->published_at , 0 , 10);
        $inputs['published_at']=date('Y-m-d H:i:s' ,(int)$realTimestampStart);
       
        $sms =   SMS::create($inputs);
        if ($sms) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SMS $sms)
    {    
        if($sms){
            return  response()->json(['status'=> 200 , 'data' => new SMSResource($sms)]);
        }else{
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SMSRequest $request, SMS $sms)
    {
        $inputs = $request->all();
        $realTimestampStart=substr($request->published_at , 0 , 10);
        $inputs['published_at']=date('Y-m-d H:i:s' ,(int)$realTimestampStart);
    
        
        $sms->update($inputs);
 
       return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SMS $sms)
    {
        $sms->delete();
        return response(['status' => 200]);
    }
    public function status(SMS $sms)
    {

        $sms->status =  $sms->status == 0 ? 1 : 0;
        $result = $sms->save();

        if ($result) {
            if ($sms->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
   
     
}
