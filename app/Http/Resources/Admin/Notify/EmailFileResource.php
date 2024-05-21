<?php

namespace App\Http\Resources\Admin\Notify;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailFileResource extends JsonResource
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
            'file_path'=>$this->file_path,
            'file_size'=>$this->file_size,
            'status'=>$this->status,
            'type'=>$this->type,
            'mail'=>new EmailResource($this->whenLoaded('mail')),

        ];
    }
}
