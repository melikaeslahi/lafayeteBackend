<?php

namespace App\Http\Resources\Admin\Content;

use App\Http\Resources\Admin\Market\ProductResource;
use App\Models\Admin\Content\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'status'=>$this->status, 
            'parent_id'=>$this->parent_id,  
            'products'=>ProductResource::collection($this->whenLoaded('products')),
            'parent'=>new SliderResource($this->whenLoaded('parent')),
            'children'=>  SliderResource::collection($this->whenLoaded('children')),


        ];
    }
}
