<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use SoftDeletes;

    protected $table = 'assets';

    protected $fillable = [
        'uuid',
        'asset_code',
        'asset_name',
        'asset_category',
        'asset_type',
        'serial_number',
        'model_number',
        'manufacturer',
        'unit_id',
        'building_id',
        'floor_id',
        'zone_id',
        'location_description',
        'department_id',
        'assigned_to',
        'vendor_id',
        'purchase_date',
        'installation_date',
        'warranty_start_date',
        'warranty_end_date',
        'purchase_cost',
        'useful_life_years',
        'status',
        'conditions',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'purchase_date'       => 'date',
        'installation_date'   => 'date',
        'warranty_start_date' => 'date',
        'warranty_end_date'   => 'date',
        'purchase_cost'       => 'decimal:2',
        'useful_life_years'   => 'integer',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(UnitDocument::class, 'unit_id', 'unit_id');
    }
}