<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSizeResource extends JsonResource
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
            'size_name'=>$this->size_name,
            'size'=>$this->size,
            'price_increase'=>$this->price_increase,
            'product'=> new ProductResource($this->whenLoaded('product')),
            'marketable_number'=>$this->marketable_number,
            'sold_number'=>$this->sold_number,
            'frozen_number'=>$this->frozen_number,
            'status'=>$this->status,


        ];
    }
}
