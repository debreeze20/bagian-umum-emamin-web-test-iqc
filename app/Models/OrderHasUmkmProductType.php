<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Str;
use Exception;

class OrderHasUmkmProductType extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id_hash' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string',
        'deleted_at' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id_hash = Str::uuid();
            } catch (Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function order_has_umkm()
    {
        return $this->belongsTo(OrderHasUmkm::class, 'order_has_umkm_id', 'id');
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function order_has_umkm_product_type_details()
    {
        return $this->hasMany(OrderHasUmkmProductTypeDetail::class, 'order_has_umkm_product_type_id', 'id');
    }

}
