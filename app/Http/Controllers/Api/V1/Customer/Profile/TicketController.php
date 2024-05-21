<?php

namespace App\Http\Controllers\Api\V1\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\StoreAnswerTicketRequest;
use App\Http\Requests\Customer\Profile\StoreTicketRequest;
use App\Http\Resources\Admin\Ticket\TicketCategoryResource;
use App\Http\Resources\Admin\Ticket\TicketPriorityResource;
use App\Http\Resources\Admin\Ticket\TicketResource;
use App\Http\Services\File\FileService;
use App\Models\Admin\Ticket\Ticket;
use App\Models\Admin\Ticket\TicketCategory;
use App\Models\Admin\Ticket\TicketFile;
use App\Models\Admin\Ticket\TicketPriority;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(){
        $tickets = auth()->user()->tickets->where('ticket_id' , null)->load('admin', 'parent');
         
        return  response()->json(['status'=>200 , 'tickets' => TicketResource::collection($tickets)]);
    }
    public function show(Ticket $ticket){
        return  response()->json(['status'=>200 , 'ticket' => new TicketResource($ticket->load('admin' , 'file' , 'children'))]);

    }
    public function  change(Ticket $ticket){
        $ticket->status = $ticket->status === 0 ?  1 : 0;
        $result = $ticket->save();
      
        return response()->json(['status' => 200]);
        

    }
    public function awnser( StoreAnswerTicketRequest $request , Ticket $ticket){
        
        $input= $request->all();
        $input['subject']= $ticket->subject;
        $input['description']= $request->description;
        $input['user_id']= auth()->user()->id;
        $input['seen']= 0;
        $input['reference_id'] = $ticket->reference_id;
        $input['ticket_id'] =  $ticket->id;
        $input['category_id'] =  $ticket->category_id;
        $input['priority_id'] =  $ticket->priority_id;
        $ticket = Ticket::create($input);
         
        if($ticket){
            return response()->json(['status' => 200]);
        }
    }

    public function  create(){
        $ticketCategories =  TicketCategory::all();
        $ticketPriorities =  TicketPriority::all();
        return  response()->json(['status'=>200 , 'ticketCategories' =>   TicketCategoryResource::collection($ticketCategories) , 'ticketPriorities'=>TicketPriorityResource::collection($ticketPriorities) ]);

        
    }

    public function store( StoreTicketRequest $request ,  FileService $fileService){
      DB::transaction(function() use ($request , $fileService) {
        $inputs=$request->all();
        $inputs['user_id']= auth()->user()->id;
        
        $ticket = Ticket::create($inputs);
  
        if ($request->hasFile('file')) {
  
          $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-file');
          $fileService->setFileSize($request->file('file'));
          $fileSize = $fileService->getFileSize();
          $resault = $fileService->moveToPublic($request->file('file'));
          // $resault = $fileService->moveToStorage($request->file('file'));
          $fileFormat =  $fileService->getFileFormat();
            
      $inputs['ticket_id']=$ticket->id;
      $inputs['user_id']= auth()->user()->id;
      $inputs['file_path']=$resault;
      $inputs['file_type']=$fileFormat;
      $inputs['file_size']=$fileSize;
    
      $file = TicketFile::create($inputs);
  
      } 
   
    
      });

      return response()->json(['status' => 200]);
       
    }
}
