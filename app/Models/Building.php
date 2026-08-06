<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'mall_id',
        'building_code',
        'building_name',
        'description',
        'total_floors',
        'total_units',
        'status',
        'created_by',
        'updated_by',
    ];

    // relationships
    public function mall()
    {
        return $this->belongsTo(Mall::class);
    }
}
