<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function create(Request $request) {
        $data = $request->validate([
            'line' => 'required',
            'from_place_id' => 'required',
            'to_place_id' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'distance' => 'required',
            'speed' => 'required',
            'status' => 'required',
        ]);
        $schedule = Schedule::create([
            'line' => $data['line'],
            'from_place_id' => $data['from_place_id'],
            'to_place_id' => $data['to_place_id'],
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'distance' => $data['distance'],
            'speed' => $data['speed'],
            'status' => $data['status'],
        ]);
        return response()->json(['message' => 'create success']);
    }
    public function update(Request $request) {
        $data = $request->validate([
            'line' => 'required',
            'from_place_id' => 'required',
            'to_place_id' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'distance' => 'required',
            'speed' => 'required',
            'status' => 'required',
        ]);
        $schedule = Schedule::where('id', $request['id']);
        $res = $schedule->update([
            'line' => $data['line'],
            'from_place_id' => $data['from_place_id'],
            'to_place_id' => $data['to_place_id'],
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'distance' => $data['distance'],
            'speed' => $data['speed'],
            'status' => $data['status'],
        ]);
        if ($res) {
            return response()->json(['message' => 'update success']);
        }
        return response()->json(['message' => 'Data cannot be updated'], 400);
        }

    public function get(Request $request) {
        return response()->json(Schedule::get());
    }

    public function delete(Request $request) {
        $schedule = Schedule::where('id', $request['id'])->delete();
        if ($schedule) {
            return response()->json(['message' => 'delete success']);
        }
    }

}
