<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $table = 'floors';

    protected $fillable = [
        'building_id',
        'floor_code',
        'floor_name',
        'floor_number',
        'status',
        'created_by',
        'updated_by',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}