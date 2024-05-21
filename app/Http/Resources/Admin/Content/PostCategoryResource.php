<?php

namespace App\Http\Resources\Admin\Content;

use App\Models\Admin\Content\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCategoryResource extends JsonResource
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
          'parent'=>new PostCategoryResource($this->whenLoaded('parent')),
           
           
        

          'slug' => $this->slug
        ];
    }
}
