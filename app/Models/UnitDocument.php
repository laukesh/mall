<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitDocument extends Model
{
    use SoftDeletes;

    protected $table = 'unit_documents';

    protected $fillable = [
        'unit_id',
        'document_type',
        'document_name',
        'document_path',
        'document_number',
        'document_date',
        'expiry_date',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'document_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
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