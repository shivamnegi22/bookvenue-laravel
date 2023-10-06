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
use Illuminate\Support\Facades\Storage;
use Exception;

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

    public function uploads(Request $request)
    {
        try {
            $currentYear = date('Y');
            $currentMonth = date('m');
            $imageUrls = [];
    
            // Check if the request contains multiple images
            if ($request->hasFile('images')) {
    
                foreach ($request->images as $image) {
                    $url = $image->store("public/uploads/$currentYear/$currentMonth");
                    $imageUrls[] = json_encode($url);
                }
            }
    
            return response([
                'image_url' => $imageUrls,
                'message' => 'Files uploaded successfully.',
            ], 200);
        } catch (Exception $e) {
    
            return response([
                'errors' => $e->getMessage(),
                'message' => "Internal Server Error.",
            ], 500);
        }
    }
    

   }
