<?php

namespace App\Models;

class WarehouseStock extends ErpModel
{
    protected $table = 'warehouse_stock';

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
