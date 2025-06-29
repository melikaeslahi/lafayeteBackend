<?php

namespace App\Http\Resources\Admin\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'title'=>$this->title,
            'body'=>$this->body,
            'status'=>$this->status,
            'tags'=>$this->tags,
            'slug'=>$this->slug
        ];
    }
}
