<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\facility;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;

class SearchController extends Controller
{

    public function searchLocation (Request $request){

        try{

            $inputLat = $request->lat;
            $inputLong = $request->lng;
        
            $facility = facility::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(`lat`)) * cos(radians(`long`) - radians(?)) + sin(radians(?)) * sin(radians(`lat`)))) AS distance',
                [$inputLat, $inputLong, $inputLat]
            )
            ->having('distance', '<=', 100)
            ->get();
        
            return response()->json(['facility' => $facility]);


         }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }
}
