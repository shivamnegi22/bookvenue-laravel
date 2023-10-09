<?php

namespace App\Http\Controllers\Api\Facility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\facility;
use Illuminate\Support\Str;

class facilityController extends Controller
{

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
                'data'  => $facility,
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
                'data'  => $facility,
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
             $images[] = str_replace('public','storage',$path);
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

    public function createFacilityVenue(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [

                'facility_id' => 'required',
                'venue_id' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $facilty_venue = new facility_venue;

            $facilty_venue->facility_id = $request->facility_id;
            $facilty_venue->venue_id = $request->venue_id;
            $facilty_venue->amenities = $request->amenities;
            $facilty_venue->start_time = $request->start_time;
            $facilty_venue->close_time = $request->close_time;
            $facilty_venue->slot_time = $request->slot_time;
            $facilty_venue->start_price = $request->start_price;
            $facilty_venue->court_count = $request->court_count;
            $facilty_venue->breaktime_start = $request->breaktime_start;
            $facilty_venue->breaktime_end = $request->breaktime_end;
            $facilty_venue->holiday = json_encode($request->holiday);
            $facilty_venue->description = $request->description;

            if($facilty_venue->save())
            {
                return response([
                    'message' => "Venue facility created successfully.",
                ],200); 
            }

        }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }


    public function getFacilitySports()
    {
        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility_sports = facility_sports::where('status','1')->get();

            return $facility_sports;

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }

    public function createFaciltiySports(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [

                'facility_id' => 'required',
                'sports_id' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $facility_sports = new facility_sports;

            $facility_sports->facility_id = $request->facility_id;
            $facility_sports->sports_id = $request->sports_id;
            $facility_sports->amenities = $request->amenities;
            $facility_sports->start_time = $request->start_time;
            $facility_sports->close_time = $request->close_time;
            $facility_sports->slot_time = $request->slot_time;
            $facility_sports->holiday = json_encode($request->holiday);
            $facility_sports->description = $request->description;

            if($facility_sports->save())
            {
                return response([
                    'message' => "Sports facility created successfully.",
                ],200); 
            }

        }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }


    public function getFacilitySportsCourt()
    {
        try{

            // $token = PersonalAccessToken::findToken($request->bearerToken());
            
            // if(empty($token)){
            //     return response([
            //         'message' => "Token expired please login again to continue.",
            //     ],401); 
            // } 

            $facility_sports_court = facility_sports_court::where('status','1')->get();

            return $facility_sports_court;

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }

    public function createFaciltiySportsCourt(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [

                'facility_id' => 'required',
                'sports_id' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $facility_sports_court = new facility_sports_court;

            $facility_sports_court->facility_id = $request->facility_id;
            $facility_sports_court->sports_id = $request->sports_id;
            $facility_sports_court->facility_sports_id = $request->facility_sports_id;
            $facility_sports_court->name = $request->name;
            $facility_sports_court->breaktime_start = $request->breaktime_start;
            $facility_sports_court->breaktime_end = $request->breaktime_end;
            $facility_sports_court->name = $request->name;
            $facility_sports_court->slot_price = $request->slot_price;
            $facility_sports_court->description = $request->description;

            if($facility_sports->save())
            {
                return response([
                    'message' => "Sports facility court created successfully.",
                ],200); 
            }

        }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }


}
