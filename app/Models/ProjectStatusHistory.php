<?php

namespace App\Models;

class ProjectStatusHistory extends ErpModel
{
    protected $table = 'project_status_history';

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
