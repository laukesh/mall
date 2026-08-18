<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PreventiveMaintenance extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'preventive_maintenance';

    protected $fillable = [
        'asset_id',
        'maintenance_code',
        'maintenance_title',
        'description',
        'maintenance_type',
        'frequency',
        'frequency_value',
        'last_maintenance_date',
        'next_due_date',
        'estimated_hours',
        'estimated_cost',
        'assigned_department_id',
        'assigned_to',
        'vendor_id',
        'checklist',
        'reminder_days',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'asset_id' => 'decimal:2',
        'frequency_value' => 'decimal:2',
        'last_maintenance_date' => 'date',
        'next_due_date' => 'date',
        'estimated_hours' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
        'assigned_department_id' => 'decimal:2',
        'assigned_to' => 'decimal:2',
        'vendor_id' => 'decimal:2',
        'reminder_days' => 'decimal:2',
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
