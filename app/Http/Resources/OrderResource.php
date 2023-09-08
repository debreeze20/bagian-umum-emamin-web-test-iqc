<?php

namespace App\Http\Resources;

use App\Models\OrderHasUmkmProductTypeDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
                $query2->where('order_id', $this->id);
            });
        })->get();

        $result = [
            'id' => $this->id_hash,
            'name' => $this->name,
            'event_date' => $this->event_date,
            'delivery_date' => $this->delivery_date,
            'reference_number' => $this->reference_number,
            'total_price' => $this->calculateTotalPrice($total_price),
            'tax' => $this->calculateTax($total_price),
            'total_price_with_tax' => $this->calculateTotalPriceWithTax($total_price),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'order_method' => new OrderMethodResource($this->whenLoaded('order_method')),
            'account_code' => new AccountCodeResource($this->whenLoaded('account_code')),
            'file' => new OrderFileResource($this->whenLoaded('file')),
            'files' => OrderFileResource::collection($this->whenLoaded('files')),           
            'order_has_umkms' => OrderHasUmkmResource::collection($this->whenLoaded('order_has_umkms')),
        ];

        return $result;
    }

    private function calculateTotalPrice($total_price)
    {
        $total = $total_price->isEmpty() ? 0 : $total_price->sum('total_price');
        return $total;
    }

    private function calculateTax($total_price)
    {
        $total = $total_price->isEmpty() ? 0 : $total_price->sum('total_price');
        $tax = ($total * config('env.tax')) / 100;
        return $tax;
    }

    private function calculateTotalPriceWithTax($total_price)
    {
        $total = $total_price->isEmpty() ? 0 : $total_price->sum('total_price');
        $tax = ($total * config('env.tax')) / 100;
        return $total + $tax;
    }
}
