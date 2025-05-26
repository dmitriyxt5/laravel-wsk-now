<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PoiFactory;

//use Modules\Poi\PoiFactory;
require_once base_path('/modules/Poi.php');
class PlaceController extends Controller
{
    //
    public function delete(Request $request) {
        $place = Place::where('id', $request['id'])->delete();
        if ($place) {
            return response()->json(['message'=> "delete success"]);
        }
    }
    public function create(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'description' => 'required'
        ]);
        $imagePath = $request->file('image')->store('public');
        $xy = (new PoiFactory())->calculate([
            'latitude'=> $data['latitude'],
            'longitude'=> $data['longitude'],
        ]);
//        return response()->json($xy);
        $place = Place::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'image_path' => $imagePath,
            'open_time' => $data['open_time'],
            'close_time' => $data['close_time'],
            'x' => $xy['x'],
            'y' => $xy['y'],
            'description' => $data['description']


        ]);
        return response()->json($place);
    }

    public function update(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'description' => 'required'
        ]);
        $imagePath = $request->file('image')->store('public');
        $xy = (new PoiFactory())->calculate([
            'latitude'=> $data['latitude'],
            'longitude'=> $data['longitude'],
        ]);
//        return response()->json($xy);
        $place = Place::where('id', $request['id']);
        $update = $place->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'image_path' => $imagePath,
            'open_time' => $data['open_time'],
            'close_time' => $data['close_time'],
            'x' => $xy['x'],
            'y' => $xy['y'],
            'description' => $data['description']


        ]);
        if ($update) {
            return response()->json($update);

        }
    }
    public function getPlace(Request $request) {
        $searchHistory = SearchHistory::where('user_id', $request->user()['id'])->pluck('count', 'place_id');

        $place = Place::get();
        $filterPlace = $place->sortByDesc(function ($element) use ($searchHistory) {
            return $searchHistory[$element['id']] ?? 0;
        });
        return response()->json($filterPlace);
    }
    public function findPlace(Request $request) {
        $place = Place::where('id', $request['id'])->first();
        $user = $request->user();
        $searchHistory = SearchHistory::where('user_id', $user['id'])->where('place_id', $request['id'])->update([
            'user_id' => $user['id'],
            'count' => DB::raw('count + 1'),
            'place_id' => $request['id'],
        ]);
        if (!$searchHistory) {

            SearchHistory::create([
                'user_id' => $user['id'],
                'count' => 1,
                'place_id' => $request['id'],
            ]);
        }
        return response()->json($place);
    }
}
