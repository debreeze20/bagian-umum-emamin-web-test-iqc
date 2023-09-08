<?php

namespace App\Http\Resources;

use App\Helpers\Utility;
use App\Models\ProductType;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderByUmkmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_qty_order = collect([]);
        $total_price_order = collect([]);
        $this->order_has_umkms->map(function ($a) use ($total_qty_order, $total_price_order){
            $a->order_has_umkm_product_types->map(function ($b) use ($total_qty_order, $total_price_order){
                $b->order_has_umkm_product_type_details->map(function ($c) use ($total_qty_order, $total_price_order){
                    $total_qty_order->push($c->qty);
                    $total_price_order->push($c->total_price);
                });
            });
        });

        $product_type_id = collect([]);
        $this->order_has_umkms->map(function ($a) use ($product_type_id){
            $a->order_has_umkm_product_types->map(function ($b) use ($product_type_id){
                $product_type_id->push($b->product_type_id);
            });
        });

        $product_type = ProductType::whereHas('order_has_umkm_product_type', function ($query) use ($product_type_id){
            $query->WhereIn('id', $product_type_id);
        })->get();

        $result = [
            'id' => $this->id_hash,
            'name' => $this->name,
            'event_date' => $this->event_date,
            'delivery_date' => $this->delivery_date,
            'reference_number' => $this->reference_number,
            'total_price' => $total_price_order->sum(),
            'total_qty' => $total_qty_order->sum(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'product_type' => ProductTypeResource::collection($product_type)
        ];

        return $result;
    }
}
