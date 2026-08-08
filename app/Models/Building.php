<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Building extends Model
{
    protected $table = 'buildings';

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

    public function mall(): BelongsTo
    {
        return $this->belongsTo(Mall::class, 'mall_id');
    }
}