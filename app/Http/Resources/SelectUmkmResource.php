<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SelectUmkmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id_hash,
            'name' => $this->name,
            'address' => $this->address,
            'subdistrict' => new SubdistrictResource($this->whenLoaded('subdistrict')),
        ];

        return $data;
    }
}
