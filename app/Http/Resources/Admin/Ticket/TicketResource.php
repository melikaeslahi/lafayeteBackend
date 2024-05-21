<?php

namespace App\Http\Resources\Admin\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id , 
            'user'=>$this->user,
            'description'=>$this->description,
            'status'=>$this->status,
            'subject'=>$this->subject,
            'category'=>$this->category,
            'priority'=>$this->priority,
            'admin'=> new TicketAdminResource($this->whenLoaded('admin')),
            'parent'=>new TicketResource( $this->whenLoaded('parent')),
            'children'=> TicketResource::collection($this->whenLoaded('children')),
            'file'=>$this->whenLoaded('file'),
            'created_at'=>$this->created_at,



        ];
    }
}
