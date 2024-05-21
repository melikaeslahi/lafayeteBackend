<?php

namespace App\Http\Resources\Admin\Market;

use App\Models\Admin\Market\CategoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryValueResource extends JsonResource
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
            'product_id'=>$this->product_id,
            'product'=>$this->product,
            'category_attribute_id'=>$this->category_attribute_id,
            'category_attribute'=>$this->attribute,
            'value'=>$this->value
             
        ];
    }
}
