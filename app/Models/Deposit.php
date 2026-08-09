<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    use SoftDeletes;

    protected $table = 'deposits';

    protected $guarded = ['id'];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Example relationships - adjust to your actual models
    public function leaseAgreement()
    {
        return $this->belongsTo(\App\Models\LeaseAgreement::class, 'lease_agreement_id');
    }
}
