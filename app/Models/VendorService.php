<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VendorService extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_services';

    protected $fillable = [
        'vendor_user_id',
        'service_name',
        'service_category',
        'description',
        'service_rate',
        'rate_unit',
        'emergency_available',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'vendor_user_id' => 'decimal:2',
        'service_rate' => 'decimal:2',
        'emergency_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
