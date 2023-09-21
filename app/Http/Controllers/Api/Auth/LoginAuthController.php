<?php

namespace App\Http\Controllers\Api\Auth;

use App\MSG91;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginAuthController extends Controller
{
    
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'mobile';
    }

    public function login(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'mobile' => 'required|max:10|exists:users,phone|regex:/^[0-9]{10}$/',
            ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422); // 422 is the HTTP status code for unprocessable entity
    }
  
    $user = User::where('phone', $request->{$this->username()})->first();

    if ($user) {

    $otp = mt_rand(100000, 999999);

    $MSG91 = new MSG91();

    $otpStatus = $MSG91->sendDltSms('62385ab87f0231333a04e445', '91'.$request->mobile, 'OTP', [$otp]);

    $user->one_time_password = Crypt::encrypt($otp);
    $user->expires_at = now()->addMinutes(5);

    if($user->update()){

    $response = [
        'OTPStatus' => $otpStatus,
        'mobile' => $request->mobile,
        'message' => 'OTP send successfully.',
    ];

    return response([
        'data' => $response,
    ],200);

    }
    
    return response([
        'error' => "Unable to update user.",
    ],400);



    }

    return response([
        'message' => "No user allocated with this Number.",
    ],401);
    
    }  
    catch(Exception $e){

        return response([
            'errors' => $e->message(),
            'message' => "Internal Server Error.",
        ],500);
    }

}


public function verifyOTP(Request $request)
{
    try{

        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6', 
        ]);
 

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422); // 422 is the HTTP status code for unprocessable entity
    }

    $user = User::where('phone',$request->mobile)->first();

    if(!$user){
        return response()->json([
            'error' => 'User not varified yet.',
        ], 401);
    }

    $expiresAt = $user->expires_at;

    if (now() > $expiresAt) {

        return response()->json([
            'error' => 'OTP Expired',
        ], 422); 

    }

    $encryptedOTP = $user->one_time_password;

            // Decrypt the OTP
    $decryptedOTP = Crypt::decrypt($encryptedOTP);


    if ($decryptedOTP == $request->otp) {
     
        $token = $user->createToken('auth_token')->plainTextToken;

        $user->update([
            'one_time_password' => null,
            'expires_at' => null,
        ]);


        return response([
            'token' =>  $token,
            'userRole' => $user->getRoleNames(),
            'message' => 'User logged in successfully.'
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
