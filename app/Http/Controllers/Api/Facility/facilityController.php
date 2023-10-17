<?php

namespace App\Http\Controllers\Api\Facility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\facility;
use App\Models\Service;
use App\Models\Facility_service;
use App\Models\Service_category;
use App\Models\Court;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class facilityController extends Controller
{

    public function getFacilityBySlug($slug){
        try{

            $facility = facility::where('slug',$slug)->first();

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

            $facility = facility::orderBy('created_at','desc')->where('status','1')->take($count)->get();

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


    public function featuredFacility($count)
    {

        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility = facility::where('status','1')->inRandomOrder()->take($count)->get();

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
                'facility_type' => 'required',
            ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422); // 422 is the HTTP status code for unprocessable entity
    }
        $facility = new facility;

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
             $cleanedString = str_replace(['\\', '"'], '', $path);
             $images[] = str_replace('public','storage',$cleanedString);
         }
     
         // Encode the entire array as JSON without escaping slashes
         $facility->images = json_encode($images);
     }
     
        if ($request->hasFile('featured_image')) {
            $url = $request->featured_image->store('public/facility');
            $facility->featured_image = str_replace('public','storage',$url);
         }
       
        $facility->time = json_encode($request->time);
        $facility->description = $request->description;
        
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


    public function getFacilityVenue()
    {

        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility_venue = facility_venue::where('status','1')->get();

            return $facility_venue;

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
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
        ], 422); // 422 is the HTTP status code for unprocessable entity
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
                $facility = facility::where ('status','1')->orderBy('created_at','desc')->get();
            }
          

            return response([
                'facility' => $facility,
            ],200);

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }
   
}



