<?php

namespace App\Http\Controllers\Api\Management;

use App\Models\Profile;
use App\Models\sports;
use App\Models\venues;
use App\Models\Role;
use App\Models\role_user;
use Illuminate\Http\Request;
use App\Models\facility_venue;
use App\Models\facility_sports;
use App\Models\facility_sports_court;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class managementController extends Controller
{
    public function profileUpdate(Request $request)
    {
        try{

            $token = PersonalAccessToken::findToken($request->bearerToken());

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 

            $userId = $token->tokenable->id;

            if($userId){

                $userData = Profile::where('user_id',$userId)->first();

                $userData->name = $request->official_name;
                $userData->email = $request->email;
                $userData->contact = $request->contact;
                $userData->landline = $request->landline;
                $userData->address = $request->address;
                $userData->interest = $request->interest;
                if($userData->update())
                {
                    return response([
                        'message' => "Profile updated successfully.",
                    ],200); 
                }
            }
            else{
                return response([
                    'message' => "Token expired please login again to continue user id.",
                ],401); 
            }

        }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ],500);
        }
    }

    public function createSports(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [

                'name' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $sports = new sports;

            $sports->name = $request->name;
            $sports->description = $request->description;

            if($sports->save())
            {
                return response([
                    'message' => "Sport created successfully.",
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

    public function createVenue(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [

                'name' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $venue = new venues;

            $venue->name = $request->name;
            $venue->description = $request->description;

            if($venue->save())
            {
                return response([
                    'message' => "Venue created successfully.",
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

    public function getUserRole(Request $request)
    {
        try{

            $token = PersonalAccessToken::findToken($request->bearerToken());

            if(empty($token)){
                return response([
                    'message' => "Token expired please login again to continue.",
                ],401); 
            } 

            $userId = $token->tokenable->id;

            if($userId){

                $role_id = role_user::where('user_id',$userId)->value('role_id');
                $role = Role::where('id',$role_id)->value('name');
              
                    return response([
                        'role' => $role,
                    ],200); 
               
            }
            else{
                return response([
                    'message' => "Token expired please login again to continue user id.",
                ],401); 
            }

        }
        catch(Exception $e){

            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
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
            $facilty_venue->location = $request->location;
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
            $facility_sports->location = $request->location;
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
}
