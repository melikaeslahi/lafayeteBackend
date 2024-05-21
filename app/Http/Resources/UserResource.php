<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\Market\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'profile_photo_path'=>$this->profile_photo_path, 
            'email'=>$this->email,
            'mobile'=>$this->mobile,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'addresses'=>new AddressResource($this->addresses),
            'national_code'=>$this->national_code,
            'user_type'=>$this->user_type,
            'products'=> ProductResource::collection($this->products),
            



        ];
    }
}
