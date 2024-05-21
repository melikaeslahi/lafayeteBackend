<?php

namespace App\Http\Resources\Admin\Content;

use App\Http\Resources\Admin\Market\ProductCategoryResource;
use App\Models\Admin\Content\PostCategory;
use App\Models\Admin\Market\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'url'=>$this->url,
            'status'=>$this->status,
            'parent_id'=>$this->parent_id,
            'productCategory'=>  new ProductCategoryResource($this->whenLoaded('productCategory')),
            'postCategory'=>  new  PostCategoryResource($this->whenLoaded('postCategory')),
             'children'=>  MenuResource::collection($this->whenLoaded('children')),   

            // 'parent'=>new MenuResource($this->whenLoaded('parent')),   
          ];
    }
}
