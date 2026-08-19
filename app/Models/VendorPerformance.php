<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VendorPerformance extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_performance';

    protected $fillable = [
        'vendor_user_id',
        'contract_id',
        'evaluation_period_start',
        'evaluation_period_end',
        'quality_rating',
        'response_rating',
        'timeliness_rating',
        'safety_rating',
        'communication_rating',
        'overall_rating',
        'jobs_assigned',
        'jobs_completed',
        'jobs_delayed',
        'sla_compliance_percentage',
        'strengths',
        'issues',
        'improvement_plan',
        'reviewer_id',
        'review_date',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'uuid' => 'string',
        'vendor_user_id' => 'decimal:2',
        'contract_id' => 'decimal:2',
        'evaluation_period_start' => 'date',
        'evaluation_period_end' => 'date',
        'quality_rating' => 'decimal:2',
        'response_rating' => 'decimal:2',
        'timeliness_rating' => 'decimal:2',
        'safety_rating' => 'decimal:2',
        'communication_rating' => 'decimal:2',
        'overall_rating' => 'decimal:2',
        'jobs_assigned' => 'decimal:2',
        'jobs_completed' => 'decimal:2',
        'jobs_delayed' => 'decimal:2',
        'sla_compliance_percentage' => 'decimal:2',
        'reviewer_id' => 'decimal:2',
        'review_date' => 'date',
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
