<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function index(Request $request) {
        $places = Place::where('from_place_id', $request['from_place_id'])->where('to_place_id', $request['to_place_id'])->where('date', '>=', $request['DEPARTURE_TIME'] ? Carbon::parse($request['DEPARTURE_TIME']) : Carbon::now())->limit(5);
        return response()->json($places);
    }


}
