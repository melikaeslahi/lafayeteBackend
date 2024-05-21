<?php

namespace App\Http\Controllers\Api\V1\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Http\Resources\Admin\Ticket\TicketResource;
use App\Models\Admin\Ticket\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function  newTickets($perPage= 0 , $search = '')
    {
        $tickets = Ticket::where('seen' , 0)->get();
        foreach ($tickets as $newTicket) {
            $newTicket->seen =1;
            $result = $newTicket->save();   
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
              return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->where('seen' , 0)->orderBy('created_at', 'desc')->get());
            }
          return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%'. $searchVal .'%')->where('seen' , 0)->orderBy('created_at', 'desc')->paginate($paginate));
        }
        else if($paginate){
            return TicketResource::collection(Ticket::with('admin' , 'parent')->where('seen' , 0)->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->where('seen' , 0)->orderBy('created_at', 'desc')->get());
          }
    }

    public function   openTickets($perPage= 0 , $search = '')
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
              return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->where('status' , 0)->orderBy('created_at', 'desc')->get());
            }
          return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%'. $searchVal .'%')->where('status' , 0)->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return TicketResource::collection(Ticket::with('admin' , 'parent')->where('status' , 0)->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->where('status' , 0)->orderBy('created_at', 'desc')->get());
          }
    }

    public function   closeTickets($perPage= 0 , $search = '')
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
              return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->where('status' , 1)->orderBy('created_at', 'desc')->get());
            }
          return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%'. $searchVal .'%')->where('status' , 1)->orderBy('created_at', 'desc')->paginate($paginate));
          
        }
        else if($paginate){
            return  TicketResource::collection(Ticket::with('admin' , 'parent')->where('status' , 1)->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->where('status' , 1)->orderBy('created_at', 'desc')->get());
          }
    }
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
              return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->whereNull('ticket_id')->orderBy('created_at', 'desc')->get());
            }
          return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%'. $searchVal .'%')->whereNull('ticket_id')->orderBy('created_at', 'desc')->paginate($paginate)); 
        }
        else if($paginate){
            return TicketResource::collection(Ticket::with('admin' , 'parent')->whereNull('ticket_id')->orderBy('created_at', 'desc')->paginate($paginate));
        }else if ($paginate === null) {
            return TicketResource::collection(Ticket::with('admin' , 'parent')->where('subject', 'like',  '%' . $searchVal . '%')->whereNull('ticket_id')->orderBy('created_at', 'desc')->get());
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
    public function show(Ticket $ticket)
    {   
        if ($ticket) {
            return  response()->json(['status' => 200, 'data' =>new TicketResource($ticket)]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function answer( TicketRequest $request ,  Ticket $ticket){
        // $ticketAdmin =auth()->user()->ticketAdmin;
        $inputs = $request->all();
         
        $inputs['subject']=$ticket->subject;
        $inputs['seen']=1;
        $inputs['category_id']=$ticket->category_id;
        $inputs['reference_id']= 1;
        $inputs['user_id']= $ticket->user_id;
        $inputs['ticket_id']=$ticket->id;
        $inputs['priority_id']=$ticket->priority_id;
        $inputs['description']=$request->description;
         
  
         $answer = Ticket::create($inputs);
         if ($answer) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
  
  
      }

      public function change(Ticket $ticket){
          
        $ticket->status = $ticket->status == 0 ? 1 : 0;
        $resault = $ticket->save();
        if ($resault) {
            return  response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404]);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
