<?php

namespace App\Models;

class LandHistory extends ErpModel
{
    protected $table = 'land_history';

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
