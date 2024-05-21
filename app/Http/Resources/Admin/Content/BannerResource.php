<?php

namespace App\Http\Resources\Admin\Content;

use App\Models\Admin\Content\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
              'id' => $this->id,
              'title'=>$this->title,
              'image'=>$this->image,
              'status'=>$this->status,
              'url'=>$this->url,
              'position'=>$this->position,
              'positions'=>Banner::$position,
             
        ];
    }
}
