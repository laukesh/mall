<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WorkOrderTask extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'work_order_tasks';

    protected $fillable = [
        'work_order_id',
        'task_number',
        'task_title',
        'task_description',
        'assigned_to',
        'priority',
        'sequence_no',
        'estimated_hours',
        'actual_hours',
        'completion_percentage',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'status',
        'completion_notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'work_order_id' => 'decimal:2',
        'assigned_to' => 'decimal:2',
        'sequence_no' => 'decimal:2',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
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
