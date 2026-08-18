<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StateCity extends Model
{
    public $timestamps = false;

    public static function getStates()
    {
        return DB::table('states')
            ->where('status', 'Active')
            ->orderBy('name')
            ->get(['name as state']);
    }

    public static function getCitiesByState($state)
    {
        if (empty($state)) {
            return [];
        }

        $stateId = DB::table('states')
            ->where('name', $state)
            ->value('id');

        if (!$stateId) {
            return [];
        }

        return DB::table('cities')
            ->where('state_id', $stateId)
            ->orderBy('name')
            ->get(['name as city']);
    }
}
