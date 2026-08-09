<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{


    protected $table = 'floors';

    protected $fillable = [
        'building_id',
        'floor_no',
        'floor_name',
        'total_units',
        'rentable_area',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'floor_no' => 'integer',
        'total_units' => 'integer',
        'rentable_area' => 'decimal:2',
    ];

    /**
     * Building
     */
    public function building()
    {
        return $this->belongsTo(
            Building::class,
            'building_id'
        );
    }

    /**
     * Units
     */
    public function units()
    {
        return $this->hasMany(
            Unit::class,
            'floor_id'
        );
    }

    /**
     * Created By
     */
    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    /**
     * Updated By
     */
    public function updatedBy()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }
}