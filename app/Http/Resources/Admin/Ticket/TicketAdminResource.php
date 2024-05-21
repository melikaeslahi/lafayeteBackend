<?php

namespace App\Http\Resources\Admin\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=>$this->id,
            'admin'=>$this->user
        ];
    }
}
