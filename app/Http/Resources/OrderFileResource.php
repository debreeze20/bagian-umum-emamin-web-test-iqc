<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class OrderFileResource extends JsonResource
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
            'path' => $this->path,
            'size' => $this->size,
            'ext' => $this->ext,
            'file_type' => $this->file_type,
            'link' => route('files.image', Crypt::encrypt($this->path, false)),
        ];

        return $data;
    }
}
