<?php

namespace App\Http\Controllers\Api\V1\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailRequest;
use App\Http\Resources\Admin\Notify\EmailResource;
use App\Models\Admin\Notify\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
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
              return EmailResource::collection(Email::with('mail')->where('subject', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return EmailResource::collection(Email::with('mail')->where('subject', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return EmailResource::collection(Email::with('mail')->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return EmailResource::collection(Email::with('mail')->where('subject', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailRequest $request)
    {
        $inputs = $request->all();
        $realTimestampStart=substr($request->published_at , 0 , 10);
        $inputs['published_at']=date('Y-m-d H:i:s' ,(int)$realTimestampStart);
         
      $email =   Email::create($inputs);
        if ($email) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Email $email)
    {
        if($email){
            return  response()->json(['status'=> 200 , 'data' =>  new EmailResource($email)]);
        }else{
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EmailRequest $request, Email $email)
    {
        $inputs = $request->all();
        $realTimestampStart=substr($request->published_at , 0 , 10);
        $inputs['published_at']=date('Y-m-d H:i:s' ,(int)$realTimestampStart);       
        $email->update($inputs);
       return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        $email->delete();
        return response(['status' => 200]);
    }
    public function status( Email  $email)
    {
        $email->status =  $email->status == 0 ? 1 : 0;
        $result = $email->save();
        if ($result) {
            if ($email->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
