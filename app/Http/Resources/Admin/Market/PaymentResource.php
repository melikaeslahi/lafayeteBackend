<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount'=>$this->amount,
            'user_id'=>$this->whenLoaded('user'),
            'payments'=>$this->whenLoaded('paymentable'),
            'type'=>$this->type,
            'status'=>$this->status
        ];
    }
}
