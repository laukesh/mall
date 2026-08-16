<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WorkOrder extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'work_orders';

    protected $fillable = [
        'work_order_number',
        'maintenance_request_id',
        'unit_id',
        'department_id',
        'assigned_to',
        'vendor_id',
        'work_title',
        'work_description',
        'priority',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'estimated_cost',
        'actual_cost',
        'completion_percentage',
        'status',
        'completion_notes',
        'verification_notes',
        'verified_by',
        'verified_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'maintenance_request_id' => 'decimal:2',
        'unit_id' => 'decimal:2',
        'department_id' => 'decimal:2',
        'assigned_to' => 'decimal:2',
        'vendor_id' => 'decimal:2',
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
        'verified_by' => 'decimal:2',
        'verified_at' => 'datetime',
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
