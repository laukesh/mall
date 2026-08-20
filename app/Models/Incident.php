<?php

namespace App\Models;

class Incident extends ErpModel
{
    protected $table = 'incidents';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
