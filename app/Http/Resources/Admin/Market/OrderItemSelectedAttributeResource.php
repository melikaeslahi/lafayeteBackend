<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemSelectedAttributeResource extends JsonResource
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
            'categoryAttribute'=>$this->categoryAttribute,
            'categoryAttributeValue'=>$this->categoryAttributeValue,
            'order_item_id'=>$this->order_item_id,
         

        ];
    }
}
