<?php

namespace App\Models;

class WorkPackageHistory extends ErpModel
{
    protected $table = 'work_package_history';

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
