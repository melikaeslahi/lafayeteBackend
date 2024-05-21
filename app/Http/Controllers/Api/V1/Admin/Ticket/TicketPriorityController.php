<?php

namespace App\Http\Controllers\Api\V1\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketPriorityRequest;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Http\Resources\Admin\Ticket\TicketPriorityResource;
use App\Http\Resources\Admin\Ticket\TicketResource;
use App\Models\Admin\Ticket\TicketPriority;
use Illuminate\Http\Request;

class TicketPriorityController extends Controller
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
                return TicketPriorityResource::collection(TicketPriority::where('name', 'like',  '%' . $searchVal . '%') ->orderBy('created_at', 'desc')->get());
            }
            return TicketPriorityResource::collection(TicketPriority::where('name', 'like',  '%' . $searchVal . '%') ->orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate) {
            return TicketPriorityResource::collection(TicketPriority::orderBy('created_at', 'desc')->paginate($paginate));
        } else if ($paginate === null) {
            return TicketPriorityResource::collection(TicketPriority::where('name', 'like',  '%' . $searchVal . '%') ->orderBy('created_at', 'desc')->get());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketPriorityRequest $request)
    {
        $inputs = $request->all();
        $productCategory =   TicketPriority::create($inputs);
        if ($productCategory) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(TicketPriority $ticketPriority)
    {
        if ($ticketPriority) {
            return  response()->json(['status' => 200, 'data' =>  new   TicketPriorityResource($ticketPriority)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(TicketPriorityRequest $request,  TicketPriority $ticketPriority)
    {
        $inputs = $request->all();
        $ticketPriority->update($inputs);
        return response()->json(['status' => 200]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketPriority $ticketPriority)
    {
        $ticketPriority->delete();
        return response(['status' => 200]);
    }
    public function status(TicketPriority $ticketPriority)
    {
        $ticketPriority->status =  $ticketPriority->status == 0 ? 1 : 0;
        $resault = $ticketPriority->save();
        if ($resault) {
            if ($ticketPriority->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    
}
