<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UmkmResource extends JsonResource
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
            'owner_name' => $this->owner_name,
            'whatsapp_number' => $this->whatsapp_number,
            'is_mbr' => $this->is_mbr,
            'address' => $this->address,
            'ktp_file' => new UmkmFileResource($this->whenLoaded('umkm_ktp_file')),
            'subdistrict' => new SubdistrictResource($this->whenLoaded('subdistrict')),
            'nik_number' => $this->nik_number,
            'npwp_number' => $this->npwp_number,
            'nib_number' => $this->nib_number,
            'bank_reference_number' => $this->bank_reference_number,
            'ktp_file' =>  UmkmFileResource::collection($this->whenLoaded('umkm_ktp_files')),
            'npwp_file' =>  UmkmFileResource::collection($this->whenLoaded('umkm_npwp_files')),
            'nib_file' =>  UmkmFileResource::collection($this->whenLoaded('umkm_nib_files')),
            'bank_reference_file' =>  UmkmFileResource::collection($this->whenLoaded('umkm_bank_files')),
            // 'files' => UmkmFileResource::collection($this->whenLoaded('files')),
            // 'product_types' => ProductTypeResource::collection($this->whenLoaded('product_types')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

        ];

        return $data;
    }
}
