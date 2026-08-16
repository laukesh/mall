<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VendorContract extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_contracts';

    protected $fillable = [
        'contract_number',
        'vendor_user_id',
        'contract_title',
        'contract_type',
        'description',
        'start_date',
        'end_date',
        'contract_value',
        'payment_terms',
        'renewal_type',
        'renewal_date',
        'notice_period_days',
        'document_path',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'vendor_user_id' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'contract_value' => 'decimal:2',
        'renewal_date' => 'date',
        'notice_period_days' => 'decimal:2',
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
