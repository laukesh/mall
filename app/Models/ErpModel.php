<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErpModel extends Model
{
    protected $guarded = [];

    public static function find($id, $columns = ['*'])
    {
        return parent::where('id', $id)->first($columns);
    }

    public static function getAllData()
    {
        return parent::all();
    }

    public static function getDataById($id)
    {
        return parent::where('id', $id)->first();
    }
}
