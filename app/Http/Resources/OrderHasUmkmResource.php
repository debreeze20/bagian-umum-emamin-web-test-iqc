<?php

namespace App\Http\Resources;

use App\Models\OrderHasUmkmProductTypeDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderHasUmkmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_price = OrderHasUmkmProductTypeDetail::whereHas('order_has_umkm_product_type', function ($query){
            $query->whereHas('order_has_umkm', function ($query2) {
                $query2->where('id', $this->id);
            });
        })->get();

        $result = [
            'id' => $this->id_hash,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'total_price' => $total_price->isEmpty() ? 0 : $total_price->sum('total_price'),
            'umkm' => new UmkmResource($this->whenLoaded('umkm')),
            'order_has_umkm_product_types' => OrderHasUmkmProductTypeResource::collection($this->whenLoaded('order_has_umkm_product_types')),
        ];

        return $result;
    }
}
