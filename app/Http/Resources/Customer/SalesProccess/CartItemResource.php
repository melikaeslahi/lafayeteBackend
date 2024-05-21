<?php

namespace App\Http\Resources\Customer\SalesProccess;

use App\Http\Resources\Admin\Market\ProductColorResource;
use App\Http\Resources\Admin\Market\ProductResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'user'=>new UserResource($this->whenLoaded('user')),
            'product'=>new  ProductResource($this->whenLoaded('product')),
            'color'=>new  ProductColorResource($this->whenLoaded('color')),
            'number'=>$this->number,
             'cartItemProductDiscount'=>$this->cartItemProductDiscount,
            'cartItemProductPrice'=>$this->cartItemProductPrice,
            'cartItemFinalPrice'=>$this->cartItemFinalPrice,
            'cartItemFinalDiscount'=>$this->cartItemFinalDiscount


        ];
    }
}
