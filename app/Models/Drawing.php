<?php

namespace App\Models;

class Drawing extends ErpModel
{
    protected $table = 'drawings';

    public function designPackage()
    {
        return $this->belongsTo(DesignPackage::class, 'design_package_id');
    }
}
