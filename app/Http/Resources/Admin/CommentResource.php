<?php

namespace App\Http\Resources\Admin;

    
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id' => $this->id,
                'body' => $this->body,
                'commentable' =>$this->whenLoaded('commentable'),
                'status' => $this->status,
                'approved' => $this->approved,
                'seen' => $this->seen,
                'parent_id'=>$this->parent_id,
                'parent' => new  CommentResource($this->whenLoaded('parent')),
                'user' => $this->whenLoaded('user'),
                'answer'=> CommentResource::collection($this->whenLoaded('answer')),
                'created_at'=>$this->created_at

            ];
    }
}
