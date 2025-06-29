<?php

namespace App\Http\Resources\Customer\Market;

use App\Models\Admin\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'data' => $this->collection,
            'meta' => [
                'total_product' => $this->collection->count(),
            ],
        ];   
    }
}
