<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MaintenanceRequest extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintenance_requests';

    protected $fillable = [
        'maintenance_number',
        'service_request_id',
        'unit_id',
        'category',
        'sub_category',
        'title',
        'description',
        'assessment',
        'priority',
        'department_id',
        'assigned_to',
        'vendor_id',
        'planned_start_date',
        'planned_end_date',
        'estimated_cost',
        'actual_cost',
        'status',
        'resolution_notes',
        'resolved_at',
        'closed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'service_request_id' => 'decimal:2',
        'unit_id' => 'decimal:2',
        'department_id' => 'decimal:2',
        'assigned_to' => 'decimal:2',
        'vendor_id' => 'decimal:2',
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
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
