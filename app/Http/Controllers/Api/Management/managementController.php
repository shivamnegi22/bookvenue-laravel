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

            $data = array();

            $serviceId = Service::where('name',$service)->value('id');

            $facilityId = Facility_service::where('service_id',$serviceId)->pluck('facility_id');

            $facility = facility::whereIn('id',$facilityId)->get();

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
