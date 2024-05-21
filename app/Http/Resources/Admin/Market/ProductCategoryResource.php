<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
            'image'=>$this->image,
            'status'=>$this->status,
            'description'=> $this->description,
            'tags'=>$this->tags,
            'parent_id'=>$this->parent_id,
            'parent'=>new ProductCategoryResource($this->whenLoaded('parent')),
            'children'=>  ProductCategoryResource::collection($this->whenLoaded('children')),

            'slug' => $this->slug
            
        ];
    }
}
