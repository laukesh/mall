<?php

namespace App\Models;

class Land extends ErpModel
{
    protected $table = 'lands';

    public function owners()
    {
        return $this->hasMany(LandOwner::class, 'land_id');
    }

    public function surveys()
    {
        return $this->hasMany(LandSurvey::class, 'land_id');
    }

    public function documents()
    {
        return $this->hasMany(LandDocument::class, 'land_id');
    }

    public function payments()
    {
        return $this->hasMany(LandPayment::class, 'land_id');
    }

    public function history()
    {
        return $this->hasMany(LandHistory::class, 'land_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
