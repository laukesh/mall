<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'units';

    protected $fillable = [
        'zone_id',
        'unit_no',
        'unit_name',
        'unit_type_id',
        'carpet_area',
        'builtup_area',
        'leasable_area',
        'frontage',
        'depth',
        'floor_level',
        'base_rent',
        'cam_rate',
        'utility_rate',
        'security_deposit',
        'current_status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function zone()
    {
        return $this->belongsTo(
            Zone::class,
            'zone_id'
        );
    }

    public function unitType()
    {
        return $this->belongsTo(
            UnitType::class,
            'unit_type_id'
        );
    }

    public function proposalUnits()
    {
        return $this->hasMany(
            ProposalUnit::class,
            'unit_id'
        );
    }

    public function floor()
	{
	    return $this->belongsTo(
	        Floor::class,
	        'floor_id'
	    );
	}
}