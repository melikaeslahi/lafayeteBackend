<?php

namespace App\Http\Resources\Admin\Market;

use App\Http\Resources\Admin\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'introduction'=>$this->introduction,
            'price'=> $this->price,
            'image'=>$this->image,
            'status'=>$this->status,
            'tags'=>$this->tags,
            'slug'=>$this->slug,
            'marketable'=>$this->marketable,
            'category_id'=> $this->category_id ,
            'category'=> new  ProductCategoryResource($this->whenLoaded('category')) ,
            'brand_id'=> $this->brand_id,
            'brand'=> new  BrandResource($this->whenLoaded('brand')),
            'frozen_number'=>$this->frozen_number,
            'marketable_number'=>$this->marketable_number,
            'sold_number'=>$this->sold_number,
            'colors'=>  ProductColorResource::collection($this->whenLoaded('colors')),
            'sizes'=>  ProductColorResource::collection($this->whenLoaded('sizes')),
            'length'=>$this->length,
            'weight'=>$this->weight,
            'height'=>$this->height,
            'published_at'=>$this->published_at,
            'comments'=> CommentResource::collection($this->whenLoaded('comments')),
            'metas'=>$this->whenLoaded('metas'),
            'gallery'=>  GalleryResource::collection($this->whenLoaded('images')) ,
            'values'=>   CategoryValueResource::collection($this->whenLoaded('values')),
            'amazingSales'=>    new AmazingSaleResource($this->activeAmazingSales),
            'activeComments'=> CommentResource::collection($this->activeComments)    
        ];
    }
}
