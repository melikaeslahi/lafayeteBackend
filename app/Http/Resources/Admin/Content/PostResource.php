<?php

namespace App\Http\Resources\Admin\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title'=> $this->title,
            'body'=> $this->body,
            'summary'=>$this->summary,
            'status'=>$this->status,
            'tags'=>$this->tags,
            'slug'=>$this->slug ,
            'commentable'=>$this->commentable,
            'image'=>$this->image,
            'category_id'=>$this->category_id,
            'category'=>new PostCategoryResource($this->whenLoaded('postCategory')),
            'auther_id'=>$this->auther_id,
            'published_at'=>$this->published_at
        ];
    }
}
