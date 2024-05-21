<?php

namespace App\Http\Resources\Admin\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'question'=>$this->question,
            'answer'=>$this->answer,
            'status'=>$this->status,
            'tag'=>$this->tag,
            'slug'=>$this->slug   
          ];
    }
}
