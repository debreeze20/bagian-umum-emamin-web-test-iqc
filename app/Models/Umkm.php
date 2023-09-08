<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $guarded = [
        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id_hash = Str::uuid();
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    protected $casts = [
        'id_hash' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string',
        'deleted_at' => 'string',
    ];

    public function umkm_files()
    {
        return $this->hasMany(UmkmFile::class, 'umkm_id', 'id');
    }

    public function order_product_type_details()
    {
        return $this->hasMany(OrderHasProductTypeDetail::class, 'umkm_id', 'id');
    }

    public function umkm_ktp_files()
    {
        return $this->hasMany(UmkmFile::class, 'umkm_id', 'id')->where('file_type', 'nik');
    }

    public function umkm_npwp_files()
    {
        return $this->hasMany(UmkmFile::class, 'umkm_id', 'id')->where('file_type', 'npwp');
    }

    public function umkm_nib_files()
    {
        return $this->hasMany(UmkmFile::class, 'umkm_id', 'id')->where('file_type', 'nib');
    }

    public function umkm_bank_files()
    {
        return $this->hasMany(UmkmFile::class, 'umkm_id', 'id')->where('file_type', 'bank_reference');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_id', 'id');
    }

    public function product_types()
    {
        return $this->belongsToMany(ProductType::class, 'umkm_has_product_types', 'umkm_id', 'product_type_id');
    }

    public function umkm_has_product_types()
    {
        return $this->hasMany(UmkmHasProductType::class, 'umkm_id', 'id');
    }

    public function umkm_has_orders()
    {
        return $this->hasMany(OrderHasUmkm::class, 'umkm_id', 'id');
    }
}
