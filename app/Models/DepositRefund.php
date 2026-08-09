<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositRefund extends Model
{
    use SoftDeletes;

    protected $table = 'deposit_refunds';

    protected $guarded = ['id'];

    protected $dates = [
        'refund_date',
        'approved_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function deposit()
    {
        return $this->belongsTo(\App\Models\Deposit::class, 'deposit_id');
    }
}
