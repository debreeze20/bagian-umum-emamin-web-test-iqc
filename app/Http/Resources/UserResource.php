<?php

namespace App\Http\Resources;

use App\Models\Industry;
use App\Traits\WhenMorphToLoaded;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use WhenMorphToLoaded;
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id_hash,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'role' => new RoleResource($this->whenLoaded('role')),
        ];

        return $result;
    }
}
