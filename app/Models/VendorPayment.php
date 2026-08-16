<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VendorPayment extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_payments';

    protected $fillable = [
        'payment_number',
        'vendor_user_id',
        'contract_id',
        'invoice_number',
        'invoice_date',
        'invoice_amount',
        'tax_amount',
        'tds_amount',
        'other_deduction',
        'net_amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'vendor_user_id' => 'decimal:2',
        'contract_id' => 'decimal:2',
        'invoice_date' => 'date',
        'invoice_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'tds_amount' => 'decimal:2',
        'other_deduction' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'payment_date' => 'date',
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
