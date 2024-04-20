<?php

namespace App\Http\Controllers\Api\Facility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\Service;
use App\Models\Facility_service;
use App\Models\Service_category;
use App\Models\Court;
use App\Models\Amenities;
use Laravel\Sanctum\PersonalAccessToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class facilityController extends Controller
{

    public function getFacilityBySlug($slug){
        try{

            $facility = facility::where('slug',$slug)->first();

            if(!empty($facility)){
                $facility["category"] = Service_category::where('id',$facility->service_category_id)->value('name');
                $facilityServices = Facility_service::where('facility_id',$facility->id)->get();
                $services = array();
                if(!empty($facilityServices)){
                    foreach($facilityServices as $items){
                        $items->name = Service::where('id',$items->service_id)->value('name');
                        $items->icon = Service::where('id',$items->service_id)->value('icon');
                        $items->court = Court::where('facility_service_id',$items->id)->get();
                        array_push($services,$items);
                    }
                }
                $facility["services"] = $services;
            }

            return response([
                'facility'  => $facility,
            ],200);

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }
    
    public function recentFacility($count)
    {

        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility = facility::orderBy('created_at','desc')->where('status','Active')->take($count)->get();

            return response([
                'recentFacility'  => $facility,
            ],200);

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }


    }


    public function featuredFacility($count)
    {

        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility = facility::where('status','Active')->inRandomOrder()->take($count)->get();

            return response([
                'facility'  => $facility,
            ],200);

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }

    }


    public function createFacility(Request $request)
    {
        try{   

            $validator = Validator::make($request->all(), [
                'officialName' => 'required',
                'service_category_id' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'featured_image' => 'required',
            ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422); // 422 is the HTTP status code for unprocessable entity
    }
        $facility = new facility;



       $facility->service_category_id = $request->service_category_id;
       $facility->official_name = $request->officialName ;
       $facility->alias = $request->alias;
       $facility->amenities = $request->amenities;
       $slug = Str::slug($request->officialName);
       $randomString = Str::random(5);
       $facility->slug =  $randomString. '-' . $slug;
       $facility->address = $request->address;
       $facility->lat = $request->latitude;
       $facility->lng = $request->longitude;
       $facility->status = 'Pending';
    
       if ($request->hasFile('featured_image')) {

        $url = $request->featured_image->store('public/facility');
        $facility->featured_image = str_replace('public','storage',$url);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if(empty($token)){
            return response([
                'message' => "Token expired please login again to continue.",
            ],401); 
        } 
        else
        {
            $userId = $token->tokenable->id;
        }

        

       $facility->description = $request->description;
       $facility->created_by =  $userId;
       

         if($facility->save())
         {
            $response = [
                'message' => 'Facility have been created successfully.',
            ];
        
            return response([
                'data' => $response,
            ],200);
         }

         return response([
            'error' => "Unable to create facility.",
        ],400);
         
    }
    catch(Exception $e){

        return response([
            'errors' => $e->message(),
            'message' => "Internal Server Error.",
        ],500);
    }
    }



    public function updateFacility(Request $request, $id)
    {
        try{

            $validator = Validator::make($request->all(), [
                'facility_type' => 'required',
            ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422); 
    }
        $facility = facility::where('id',$id)->where('status','1')->first();

        $facility->facility_type = $request->facility_type;
        $facility->official_name = $request->name;

        $slug = Str::slug($request->name);
        $randomString = Str::random(5);

        $facility->slug = $slug . '-' . $randomString;
        $facility->alias = $request->alias;
        $facility->address = $request->address;
        $facility->lat = $request->lat;
        $facility->long = $request->long;
        if ($request->hasFile('images')) {
         $images = [];
     
         foreach ($request->file('images') as $image) {
             $path = $image->store('public/facility');
             $images[] = str_replace('public','storage',$path);
         }
     
         // Encode the entire array as JSON without escaping slashes
         $facility->images = json_encode($images, JSON_UNESCAPED_SLASHES);
     }
     
        if ($request->hasFile('featured_image')) {
            $url = $request->featured_image->store('public/facility');
            $facility->featured_image = str_replace('public','storage',$url);
         }
       
        $facility->time = json_encode($request->time);
        $facility->description = $request->description;
        
         if($facility->update())
         {
            $response = [
                'message' => 'Facility have been updated successfully.',
            ];
        
            return response([
                'data' => $response,
            ],200);
         }

         return response([
            'error' => "Unable to update facility.",
        ],400);
         
    }
    catch(Exception $e){

        return response([
            'errors' => $e->message(),
            'message' => "Internal Server Error.",
        ],500);
    }  
  }

    public function deleteFacility($id)
    {
        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility = facility::find($id);

            if (!$facility) {
                return response()->json(['message' => 'Record not found'], 404);
            }

            $facilityVenuCount = facility_venue::where('facility_id', $id)->count();
            $facilitySportCount = facility_sports::where('facility_id', $id)->count();
            $facilitySportCourtCount = facility_sports_court::where('facility_id', $id)->count();
    
            if ($facilityVenuCount > 0 || $facilitySportCount > 0 || $facilitySportCourtCount > 0) {

                return response([
                    'message' => "Facility has related records and cannot be deleted.",
                ],404); 

            }

            if($facility->delete())
            {
                return response([
                    'message' => "Facility deleted successfully.",
                ],200); 
            }

         }
         catch(\Exception $e){
            return response([
                    'message' => "Something went wrong please try again.",
                ],500); 
        }
    }
 
    

    public function getAllFacility(Request $request)
    {
        try{

            $inputLat = $request->lat;
            $inputLong = $request->lng;

            $data = array();

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 
            if($inputLat && $inputLong)
            {
                $facility = facility::select('*')
                ->selectRaw(
                    '(6371 * acos(cos(radians(?)) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(?)) + sin(radians(?)) * sin(radians(`lat`)))) AS distance',
                    [$inputLat, $inputLong, $inputLat]
                )
                ->orderBy('distance')
                ->get();

            }
            else
            {
                $facility = facility::where('status','Active')->get();


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
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }

    public function addServices(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'facility_id' => 'required',
                'services_id' => 'required',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }
    
        // return $courtData;

        $facility_service = new Facility_service;

        $facility_service->facility_id = $request->facility_id;
        $facility_service->service_id = $request->services_id;
        if ($request->hasFile('images')) {
            $images = [];
        
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/facility');
                $cleanedString = str_replace(['\\', '"'], '', $path);
                $images[] = str_replace('public','storage',$cleanedString);
            }
        
            // Encode the entire array as JSON without escaping slashes
            $facility_service->images = json_encode($images);
        }

        if ($request->hasFile('featured_image')) {
            $url = $request->featured_image->store('public/facility');
            $facility_service->featured_image = str_replace('public','storage',$url);
         }

        $facility_service->upcoming_holiday = json_encode($request->holiday);
        $facility_service->description = $request->description;
        $facility_service->created_by = '1';

        if($facility_service->save())
        {

            return response([
                'message' => "Service created successfully.",
                'facility_service_id' => $facility_service->id,
            ],200); 

            
        }
    
    } catch(Exception $e){

        return response([
            'errors' => $e->message(),
            'message' => "Internal Server Error.",
        ],500);
    }
   
}


    public function createCourt(Request $request)
    {
        
    try{

        $validator = Validator::make($request->all(), [
            'facility_service_id' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422); // 422 is the HTTP status code for unprocessable entity
        }

        $courtsDataJSON = $request->input('courts_data');
        $courtsData = json_decode($courtsDataJSON, true);

        foreach ($courtsData as $data) {

            $court = new Court;
        
            $court->facility_service_id = $request->facility_service_id;
            $court->court_name = $data['courtName'];
            $court->start_time = $data['startTime'];
            $court->end_time = $data['endTime'];
            $court->slot_price = $data['price']; 
            $court->duration = $data['duration'];
        
            $breaks = [];
            foreach ($data['breakTimes'] as $break) {
                $breaks[] = [
                    'start' => $break['start'],
                    'end' => $break['end'],
                ];
            }
            $court->breaks = json_encode($breaks);
            $court->created_by = '1';
        
            // Save the court
            if($court->save())
            {
                return response([
                    'message' => "Court created successfully.",
                ],200); 
            }
        }

    }
    catch(Exception $e){

        return response([
            'errors' => $e->message(),
            'message' => "Internal Server Error.",
        ],500);
    }

    }


    public function allProviderData(Request $request)
    {
        try{

            $token = PersonalAccessToken::findToken($request->bearerToken());

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 

            $userId = $token->tokenable->id;

            $facility = facility::where('created_by',userId)->get();

            $provider = [];
    
            foreach($facility as  $value)
            {
                
                $obj = new \stdClass();
    
                $obj->facility_name = $value->offcial_name;
                $obj->alias = $value->alias;
                $obj->address = $value->address;
                $obj->featured_image = $value->featured_image;
                $obj->status = $value->status;
                $obj->service = array();
                
                $service_id= Facility_service::where('facility_id',$value->id)->value('service_id');
                $facility_service_id= Facility_service::where('facility_id',$value->id)->value('id');
                $service = Service::where('id',$service_id)->get();
    
                foreach($service as $serviceData)
                {
                      $service_data = new \stdClass();
                      $service_data->service_name = $serviceData->name;
                      $service_data->service_category = Service_category::where('id',$serviceData->service_category_id)->value('name');
                      $service_data->icon = $serviceData->icon;
                      $service_data->featured_image = $serviceData->featured_image;
                      $service_data->description = $serviceData->description;
                      $service_data->courtData = array();
    
                      $court = Court::where('facility_service_id',$facility_service_id)->get();
    
                      foreach($court as $courtData)
                      {
                        $court_data = new \stdClass();
    
                        $court_data->court_name = $courtData->court_name;
                        $court_data->start_time = $courtData->start_time;
                        $court_data->end_time = $courtData->end_time;
                        $court_data->slot_price = $courtData->slot_price;
                        $court_data->duration = $courtData->duration;
                        $court_data->breaks = $courtData->breaks;
                        $court_data->description = $courtData->description;
    
                        array_push($service_data->courtData,   $court_data);
                      }
    
                      array_push($obj->service,$service_data);
    
                }
    
                $provider[] = $obj;
            
    
                return response([
                    'providerData' => $provider,
                ],200); 
            }
    
            
        }catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }
   
}