<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Str;
use Exception;

class OrderHasUmkm extends Model
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

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'id');
    }
    
    public function order_has_umkm_product_types()
    {
        return $this->hasMany(OrderHasUmkmProductType::class, 'order_has_umkm_id', 'id');
    }

}
