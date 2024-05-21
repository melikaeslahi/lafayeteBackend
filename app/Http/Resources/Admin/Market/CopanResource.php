<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CopanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'code'=>$this->code,
            'amount'=>$this->amount,
            'amount_type'=>$this->amount_type,
            'type'=>$this->type,
            'user_id'=>$this->user_id,
            'user'=>$this->user,
            'discount_ceiling'=>$this->discount_ceiling,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
        ];
    }
}
