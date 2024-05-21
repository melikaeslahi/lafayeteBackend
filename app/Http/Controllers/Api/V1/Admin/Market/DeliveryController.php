<?php

namespace App\Http\Controllers\Api\V1\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\DeliveryRequest;
use App\Http\Resources\Admin\Market\DeliveryResource;
use App\Models\Admin\Market\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
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
              return DeliveryResource::collection(Delivery::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return DeliveryResource::collection(Delivery::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return DeliveryResource::collection(Delivery::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return DeliveryResource::collection(Delivery::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryRequest $request)
    {
        $inputs = $request->all();
        $delivery =  Delivery::create($inputs);
        if ($delivery) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
         if ($delivery) {
             return  response()->json(['status' => 200, 'data' => new DeliveryResource($delivery) ]);
         } else {
             return response()->json(['status' => 404]);
         }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( DeliveryRequest $request,  Delivery $delivery)
    {
        $inputs=$request->all();
        $delivery->update($inputs);
        return response()->json(['status' => 200]);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return response(['status' => 200]);
    }
 
}
