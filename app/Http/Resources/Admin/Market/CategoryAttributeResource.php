<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAttributeResource extends JsonResource
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
            'name'=>$this->name,
            'unit'=>$this->unit,
            'category_id'=>$this->category_id,
            'category'=>$this->category,
             
        ];
    }
}
