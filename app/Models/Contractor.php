<?php

namespace App\Models;

class Contractor extends ErpModel
{
    protected $table = 'contractors';

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_contractor_id');
    }

    public function subContractors()
    {
        return $this->hasMany(self::class, 'parent_contractor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isMainContractor(): bool
    {
        return $this->contractor_type === 'Main Contractor';
    }

    public function isSubContractor(): bool
    {
        return $this->contractor_type === 'Sub Contractor';
    }
}
