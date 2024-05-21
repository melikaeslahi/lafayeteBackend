<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'number'=>$this->number,
            'final_product_price'=>$this->final_product_price,
            'final_total_price'=>$this->final_total_price,
            'amazing_sale_discount_amount'=>$this->amazing_sale_discount_amount,
            'singleProduct'=>new ProductResource($this->whenLoaded('singleProduct')),
            'amazingSale'=>new AmazingSaleResource($this->whenLoaded('amazingSale')),
            'color'=>new ProductColorResource($this->whenLoaded('color')),
            'orderItemsAttributes'=>OrderItemSelectedAttributeResource::collection($this->whenLoaded('orderItemsAttributes') ),

        ];
    }
}
