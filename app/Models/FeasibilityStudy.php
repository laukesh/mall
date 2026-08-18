<?php

namespace App\Models;

class FeasibilityStudy extends ErpModel
{
    protected $table = 'feasibility_studies';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function soilInvestigations()
    {
        return $this->hasMany(SoilInvestigation::class, 'feasibility_id');
    }

    public function riskAssessments()
    {
        return $this->hasMany(RiskAssessment::class, 'feasibility_id');
    }
}
