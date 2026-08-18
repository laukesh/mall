<?php

namespace App\Models;

class DesignPackage extends ErpModel
{
    protected $table = 'design_packages';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function drawings()
    {
        return $this->hasMany(Drawing::class, 'design_package_id');
    }
}
