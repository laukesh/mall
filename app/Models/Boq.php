<?php

namespace App\Models;

class Boq extends ErpModel
{
    protected $table = 'boq';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
