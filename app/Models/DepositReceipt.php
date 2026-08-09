<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositReceipt extends Model
{
    use SoftDeletes;

    protected $table = 'deposit_receipts';

    protected $guarded = ['id'];

    protected $dates = [
        'receipt_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function deposit()
    {
        return $this->belongsTo(\App\Models\Deposit::class, 'deposit_id');
    }
}
