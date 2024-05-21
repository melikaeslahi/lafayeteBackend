<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'mobile'=>$this->mobile,
            'email'=>$this->email,
            'description'=>$this->description,
            'image'=>$this->image,
            'activation'=>$this->activation
        ];
    }
}
