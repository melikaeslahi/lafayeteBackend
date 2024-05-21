<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
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
            'roles'=> RoleResource::collection($this->whenLoaded('roles')),
            'permissions'=>  PermissionResource::collection($this->whenLoaded('permissions')),
            'mobile'=>$this->mobile,
            'email'=>$this->email,
            'description'=>$this->description,
            'profile_photo_path'=>$this->profile_photo_path,
            'activation'=>$this->activation,
            'status'=>$this->status

        ];
    }
}
