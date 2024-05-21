<?php

namespace App\Http\Resources\Customer\Market;

use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'data' => $this->collection->transform(function (Product $product) {
                return new  ProductResource($product);
            }),
            'meta' => [
                'total_product' => $this->collection->count(),
            ],
        ];   
    }
}
