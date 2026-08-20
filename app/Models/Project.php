<?php

namespace App\Models;

class Project extends ErpModel
{
    protected $table = 'projects';

    public function lands()
    {
        return $this->hasMany(Land::class, 'project_id');
    }
}
