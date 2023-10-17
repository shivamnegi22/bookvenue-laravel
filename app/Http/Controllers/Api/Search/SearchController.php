<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\facility;
use App\Models\Service_category;
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

            $data = array();
        
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

            if(!empty($facility))
            {
                foreach($facility as $item)
                {
                    $item->category = Service_category::where('id',$item->service_category_id)->value('name');
                    $facilityServices = Facility_service::where('facility_id',$item->id)->get();
                    $services = array();
                    if(!empty($facilityServices)){
                        foreach($facilityServices as $items){
                            $items->name = Service::where('id',$items->service_id)->value('name');
                            $items->icon = Service::where('id',$items->service_id)->value('icon');
                            array_push($services,$items);
                        }
                    }
                    $item->services = $services;
                    array_push($data,$item);
                }
            }
        
            return response([
                'facility' => $data,
            ],200);



         }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }
}
