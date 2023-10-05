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
        $facility->location = $request->location;
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
}
