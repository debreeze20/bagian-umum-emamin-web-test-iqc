<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppVersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $appTypeName = null;

        if ($this->app_type == 'web') {
            $appTypeName = 'Website';
        } elseif ($this->app_type == 'android') {
            $appTypeName = 'Android';
        } elseif ($this->app_type == 'ios') {
            $appTypeName = 'IOS';
        }

        $result = [
            'id' => $this->id_hash,
            'code' => $this->code,
            'is_force_update' => $this->is_force_update,
            'description' => $this->description,
            'app_type' => $this->app_type,
            'app_type_name' => $appTypeName,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];

        return $result;
    }
}
