<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorResource extends JsonResource
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
            'color_name'=>$this->color_name,
            'color'=>$this->color,
            'price_increase'=>$this->price_increase,
            'product'=> new ProductResource($this->whenLoaded('product')),
            'marketable_number'=>$this->marketable_number,
            'sold_number'=>$this->sold_number,
            'frozen_number'=>$this->frozen_number,
            'status'=>$this->status,
        ];
    }
}
