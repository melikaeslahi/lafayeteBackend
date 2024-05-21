<?php

namespace App\Http\Resources\Admin\Market;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'persian_name'=>$this->persian_name,
            'original_name'=>$this->original_name,
            'logo'=>$this->logo,
            'status'=>$this->status,
            'tags'=>$this->tags,
            'slug'=>$this->slug
        ];
    }
}
