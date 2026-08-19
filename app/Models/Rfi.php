<?php

namespace App\Models;

class Rfi extends ErpModel
{
    protected $table = 'rfis';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
