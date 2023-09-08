<?php

namespace App\Http\Resources;

use App\Helpers\Utility;
use App\Models\OrderHasUmkmProductTypeDetail;
use App\Models\ProductType;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product_type = ProductType::whereHas('order_has_umkm_product_type', function ($query){
            $query->whereHas('order_has_umkm', function ($query2) {
                $query2->where('order_id', $this->id);
            });
        })->get();

        $total_price = OrderHasUmkmProductTypeDetail::whereHas('order_has_umkm_product_type', function ($query){
            $query->whereHas('order_has_umkm', function ($query2) {
                $query2->where('order_id', $this->id);
            });
        })->get();

        $result = [
            'id' => $this->id_hash,
            'name' => $this->name,
            'event_date' => $this->event_date,
            'delivery_date' => $this->delivery_date,
            'reference_number' => $this->reference_number,
            'total_price' => $total_price->isEmpty() ? 0 : $total_price->sum('total_price'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'product_type' => ProductTypeResource::collection($product_type),
            
        ];

        return $result;
    }
}
