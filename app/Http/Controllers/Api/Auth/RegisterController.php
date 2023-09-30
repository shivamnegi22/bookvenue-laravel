<?php

namespace App\Http\Controllers\Api\Auth;
use App\MSG91;
use App\Models\user;
use App\Models\Role;
use App\Models\role_user;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'mobile' => 'required|max:10|regex:/^[0-9]{10}$/',
                'role' => 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity

        }

        $userExist = user::where('phone',$request->mobile)->first();

        if($userExist){
            return response()->json([
                'error' => 'Validation failed',
                'errors' => "Mobile No already exist.",
            ], 422);
        }

        $otp = mt_rand(100000, 999999);

        $user = new user;
        $user->phone = $request->mobile;
        $user->one_time_password = Crypt::encrypt($otp);
        $user->expires_at = now()->addMinutes(5);
        
        if($user->save()){

            // $user->assignRole('user');

            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->contact = $request->mobile;
            $profile->name = $request->name;

            if($profile->save()){

                $role_id = Role::where('slug',$request->role)->value('id');
                
                $role_user = new role_user;
                $role_user->user_id =  $user->id;
                $role_user->role_id = $role_id;

                if($role_user->save())
                {

                $MSG91 = new MSG91();
                $otpStatus =    $MSG91->sendDltSms('62385ab87f0231333a04e445', '91'.$request->mobile, 'OTP', [$otp]);

                return response([
                    'OTPStatus' => $otpStatus,
                    'mobile' => $request->mobile,
                    'message' => 'OTP send successfully.',
                ],200);
            }

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

    public function verifyuser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'mobile' => 'required|max:10|exists:users,phone|regex:/^[0-9]{10}$/',
                'otp' => 'required|max:6|regex:/^[0-9]{6}$/',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }

            $user = user::where('phone',$request->mobile)->first();
            
            if(!$user){
                return response()->json([
                    'error' => 'user not found.',
                ], 401);
            }

            
            // Get the expiration time for the OTP
            $expiresAt = $user->expires_at;

            if (now() > $expiresAt) {

                return response()->json([
                    'error' => 'OTP Expired',
                ], 422); 

            }

             // Retrieve the encrypted OTP from the database
             $encryptedOTP = $user->one_time_password;

             // Decrypt the OTP
             $decryptedOTP = Crypt::decrypt($encryptedOTP);

             if ($decryptedOTP == $request->otp) {

                $token = $user->createToken('auth_token')->plainTextToken;

                $user->update([
                    'verified' => true,
                    'one_time_password' => null,
                    'expires_at' => null,
                    'mobile_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]);

                $profile = Profile::where('user_id',$user->id)->first();

                return response([
                    'token' =>  $token,
                    'userRole' => $user->getRoleNames(),
                    'message' => 'user registered successfully.'
                ],200);

                }

                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

        catch(Exception $e){
            return response([
                    'errors' => $e->message(),
                    'message' => "Internal Server Error.",
                ],500); 
        }
    }
}
