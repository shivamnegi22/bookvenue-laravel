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
            $count = $request->count;
        
            $facility = array();
            
            if($count){

            
            $facility = facility::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(?)) + sin(radians(?)) * sin(radians(`lat`)))) AS distance',
                [$inputLat, $inputLong, $inputLat]
            )
            ->having('distance', '<=', 50)->take($count)
            ->get();

            }else{
                $facility = facility::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(?)) + sin(radians(?)) * sin(radians(`lat`)))) AS distance',
                [$inputLat, $inputLong, $inputLat]
            )
            ->having('distance', '<=', 50)
            ->get();
            }
        
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
