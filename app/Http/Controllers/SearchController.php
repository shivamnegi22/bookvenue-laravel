<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\facility;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //

    public function searchLocation (Request $request){
        // try{


            $inputLat = $request->lat;
            $inputLong = $request->lng;
        
            $locations = facility::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(`lat`)) * cos(radians(`long`) - radians(?)) + sin(radians(?)) * sin(radians(`lat`)))) AS distance',
                [$inputLat, $inputLong, $inputLat]
            )
            ->having('distance', '<=', 100)
            ->get();
        
            return response()->json(['locations' => $locations]);

            // return response([
            //     'lat' => $request->lat,
            //     'long' => $request->lng,
            // ],200);

        //  }
        //  catch(\Exception $e){
        //     return response([
        //             'message' => "something went wrong please try again.",
        //         ],500); 
        // }
    }
}
