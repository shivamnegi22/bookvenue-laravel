<?php

namespace App\Http\Controllers\Api\Management;

use App\Models\Profile;
use Illuminate\Http\Request;
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
}
