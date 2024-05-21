<?php

namespace App\Http\Controllers\Api\V1\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\FaqStoreRequest;
use App\Http\Requests\Admin\Content\FaqUpdateRequest;
use App\Http\Resources\Admin\Content\FaqResource;
use App\Models\Admin\Content\Faq;
 

class FaqController extends Controller
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
              return FaqResource::collection(Faq::where('question', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
           return  FaqResource::collection(Faq::where('question', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
            
        }
        else if($paginate){
            return FaqResource::collection(Faq::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return FaqResource::collection(Faq::where('question', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqStoreRequest $request)
    {
        $inputs = $request->all();
        $faq =  Faq::create($inputs);
        if($faq){
           return response()->json(['status' => 200]);
       }else {
           return response()->json(['status' => 404]);
       }
         
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
          if ($faq) {
              return  response()->json(['status' => 200, 'data' =>   new FaqResource($faq)]);
          } else {
              return response()->json(['status' => 404]);
          }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqUpdateRequest $request, Faq $faq)
    {
        $inputs = $request->all();
        $faq->update($inputs);

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response(['status' => 200]);
    }

    public function status(Faq $faq)
    {

        $faq->status =  $faq->status == 0 ? 1 : 0;
        $result = $faq->save();

        if ($result) {
            if ($faq->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }  
}
