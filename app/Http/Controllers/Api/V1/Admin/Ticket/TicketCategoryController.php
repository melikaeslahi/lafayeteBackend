<?php

namespace App\Http\Controllers\Api\V1\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketCategoryRequest;
use App\Http\Resources\Admin\Ticket\TicketCategoryResource;
use App\Models\Admin\Ticket\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($perPage= 0 , $search = '')
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
              return TicketCategoryResource::collection(TicketCategory::where('‌name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
            }
          return TicketCategoryResource::collection(TicketCategory::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return TicketCategoryResource::collection(TicketCategory::orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return TicketCategoryResource::collection(TicketCategory::where('name', 'like',  '%' . $searchVal . '%')->orderBy('created_at', 'desc')->get());
          }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketCategoryRequest $request)
    {
        $inputs = $request->all();
        $ticketCategory =   TicketCategory::create($inputs);
        if ($ticketCategory) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(TicketCategory $ticketCategory)
    {
        if ($ticketCategory) {
            return  response()->json(['status' => 200, 'data' => new TicketCategoryResource($ticketCategory)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(  TicketCategoryRequest $request,  TicketCategory $ticketCategory)
    {
        $inputs = $request->all();
        $ticketCategory->update($inputs);

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketCategory $ticketCategory)
    {
        $ticketCategory->delete();
        return response(['status' => 200]);
    }
    public function status(TicketCategory $ticketCategory)
    {
        $ticketCategory->status =  $ticketCategory->status == 0 ? 1 : 0;
        $resault = $ticketCategory->save();

        if ($resault) {
            if ($ticketCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {

            return response()->json(['status' => false]);
        }
    }
}
