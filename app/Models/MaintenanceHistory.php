<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MaintenanceHistory extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintenance_history';

    protected $fillable = [
        'history_number',
        'asset_id',
        'work_order_id',
        'preventive_maintenance_id',
        'maintenance_type',
        'maintenance_date',
        'description',
        'problem_reported',
        'work_performed',
        'findings',
        'parts_replaced',
        'technician_id',
        'vendor_id',
        'downtime_hours',
        'labour_cost',
        'material_cost',
        'total_cost',
        'condition_before',
        'condition_after',
        'warranty_claim',
        'next_maintenance_date',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'asset_id' => 'decimal:2',
        'work_order_id' => 'decimal:2',
        'preventive_maintenance_id' => 'decimal:2',
        'maintenance_date' => 'date',
        'technician_id' => 'decimal:2',
        'vendor_id' => 'decimal:2',
        'downtime_hours' => 'decimal:2',
        'labour_cost' => 'decimal:2',
        'material_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'warranty_claim' => 'boolean',
        'next_maintenance_date' => 'date',
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
