<?php

namespace App\Http\Controllers\Api\Management;

use App\Models\Profile;
use App\Models\facility;
use App\Models\Role;
use App\Models\role_user;
use App\Models\Service;
use App\Models\Amenities;
use App\Models\Service_category;
use App\Models\Facility_service;
use Illuminate\Http\Request;
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
                foreach ($request->file('images') as $image) {
                    // Store each image and get its URL
                    $url = $image->store("public/uploads/$currentYear/$currentMonth");
                    $imageUrls[] = asset(str_replace('public/', 'storage/', $url));
                }
            }
    
            return response([
                'image_urls' => $imageUrls,
                'message' => 'Files uploaded successfully.',
            ], 200);
        } catch (Exception $e) {
            return response([
                'errors' => $e->getMessage(),
                'message' => "Internal Server Error.",
            ], 500);
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
            if ($request->hasFile('featured_image')) {
                $sports->featured_image = $request->featured_image;
                }
                if ($request->hasFile('icon')) {
                $sports->icon = $request->icon;
                }
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

    public function getAllSports(Request $request){
        try{

            $sports = sports::orderBy('created_at','desc')->get();

           return $sports;

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }

    public function updateSports($id, Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [

               
                'featured_image'      =>  'mimes:png,svg|max:500',
                'icon'                =>  'mimes:png,svg|max:200',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }
    
            $sport = sports::where('id',$id)->first();
    
            $sport->name = $request->name;
            if ($request->hasFile('featured_image')) {
            $sport->featured_image = $request->featured_image;
            }
            if ($request->hasFile('icon')) {
            $sport->icon = $request->icon;
            }
            $sport->description = $request->description;
            
            if($sport->update())
            {
                return response([
                    'message' => "Sport updated successfully.",
                ],200); 
            }
    

        }
        catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }

    }

    public function deleteSports($id)
    {

        try{

            $sport = sports::find($id);
    
            if (!$sport) {
                return response()->json(['message' => 'Record not found'], 404);
            }
    
            // Check if there are related records in the related tables
    
            $facilitySportCount = facility_sports::where('sports_id', $id)->count();
            $facilitySportCourtCount = facility_sports_court::where('sports_id', $id)->count();
    
            if ( $facilitySportCount > 0 || $facilitySportCourtCount > 0) {

                return response([
                    'message' => "Sport has related records and cannot be deleted.",
                ],404); 
            }
    
            if($sport->delete())
            {
                return response([
                    'message' => "Sport deleted successfully.",
                ],200); 
            }

        }
        catch(\Exception $e){
            return response([
                    'message' => "Something went wrong please try again.",
                ],500); 
        }
    }

    public function getAllVenues(Request $request){

        try{

            $venues = venues::orderBy('created_at','desc')->get();

           return $venues;

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
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
            if ($request->hasFile('featured_image')) {
                $venue->featured_image = $request->featured_image;
                }
                if ($request->hasFile('icon')) {
                $venue->icon = $request->icon;
                }
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

    public function updateVenue($id, Request $request)
    {

        try{

            
            $validator = Validator::make($request->all(), [

            'featured_image'      =>  'mimes:png,svg|max:500',
            'icon'                =>  'mimes:png,svg|max:200',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }
    
            $venue = venues::where('id',$id)->first();

            $venue->name = $request->name;
            if ($request->hasFile('featured_image')) {
            $venue->featured_image = $request->featured_image;
            }
            if ($request->hasFile('icon')) {
            $venue->icon = $request->icon;
            }
            $venue->description = $request->description;

            if($venue->update())
            {
                return response([
                    'message' => "Venue updated successfully.",
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

    public function deleteVenue($id)
    {

        try{

            $venue = venues::find($id);

            if (!$venue) {
                return response()->json(['message' => 'Record not found'], 404);
            }
    
            // Check if there are related records in the related tables
    
            $facilityVenuCount = facility_venue::where('venue_id', $id)->count();
    
            if ($facilityVenuCount > 0) {
                return response([
                    'message' => "Venue has related records and cannot be deleted.",
                ],404); 
            }
    
            if($venue->delete())
            {
                return response([
                    'message' => "Venue deleted successfully.",
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

    public function getAllServices()
    {
        try{

            $service_types = Service_category::get();
            $services = array();

            if(!empty($service_types)){
                foreach($service_types as $type){
                    $type['services'] = Service::where('service_category_id',$type->id)->get();
                   array_push($services,$type);
                }
            }


            return response([
                'services' => $services,
            ],200);

        }
        catch(Exception $e){

            return response([
                'message' => "Internal Server Error.",
            ],500);
        }
    }

    public function getFacilityByCategory($cat,$service,Request $request)
    {
        try{

            $service_category = Service_category::where('name',$cat)->value('id');

            $facility = facility::where('service_category_id',$service_category)->get();

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

    public function getAllAmenities()
    {
        try{

            $amenities = Amenities::get();

            return response([
                'amenities' => $amenities,
            ],200);

         }
         catch(\Exception $e){
            return response([
                    'message' => "something went wrong please try again.",
                ],500); 
        }
    }

   }
