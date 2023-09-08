<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Str;
use Exception;

class Role extends Model
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

    protected $softCascade = [
        'users'
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

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
