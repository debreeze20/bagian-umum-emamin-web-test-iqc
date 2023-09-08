<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Str;
use Exception;

class Order extends Model
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

    public function order_method()
    {
        return $this->belongsTo(OrderMethod::class, 'order_method_id', 'id');
    }

    public function account_code()
    {
        return $this->belongsTo(AccountCode::class, 'account_code_id', 'id');
    }

    public function order_has_umkms()
    {
        return $this->hasMany(OrderHasUmkm::class, 'order_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class, 'order_id', 'id');
    }

    public function file()
    {
        return $this->hasOne(OrderFile::class, 'order_id', 'id');
    }
}
