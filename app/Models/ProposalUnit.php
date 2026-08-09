<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalUnit extends Model
{
    use SoftDeletes;

    protected $table = 'proposal_units';

    protected $fillable = [
        'proposal_id',
        'unit_id',
        'proposed_rent',
        'proposed_cam_rate',
        'proposed_security_deposit',
        'rent_free_days',
        'fitout_period_days',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
