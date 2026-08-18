<?php

namespace App\Http\Controllers;

use App\Models\StateCity;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getCities(Request $request)
    {
        $cities = StateCity::getCitiesByState($request->state);

        return response()->json($cities);
    }
}
