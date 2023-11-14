<?php

namespace App\Http\Controllers\Api\Auth;

use App\MSG91;
use App\Models\User;
use Firebase\JWT\JWT;
use Dotenv\Dotenv;
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
    try {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[0-9]{10}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if user exists with the provided mobile number
        $user = User::where('phone', $request->mobile)->first();

        if (!$user) {
            // If the user doesn't exist, create a new user
            $user = new User;

            $user->phone = $request->mobile;
            $user->status = 'Active';
            $user->save();
        }

        // Generate OTP
        $otp = mt_rand(100000, 999999);

        // Store OTP in Session
        $request->session()->put('otp', $otp);

        // Additional steps for sending OTP via SMS...
        $MSG91 = new MSG91();
        $otpStatus = $MSG91->sendDltSms('62385ab87f0231333a04e445', '91' . $request->mobile, 'OTP', [$otp]);

        // Respond with success message
        return response([
            'OTPStatus' => $otpStatus,
            'mobile' => $request->mobile,
            'message' => 'OTP sent successfully.',
        ], 200);
    } catch(Exception $e) {
        return response([
            'errors' => $e->getMessage(),
            'message' => "Internal Server Error.",
        ], 500);
    }
}

    

    public function verifyOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|max:10|regex:/^[0-9]{10}$/',
                'otp' => 'required|digits:6',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }
    
            // Check if the user exists
            $user = User::where('phone', $request->mobile)->first();
    
            if (!$user) {
                // If the user doesn't exist, create a new user
                $user = User::create([
                    'phone' => $request->mobile,
                    // Other user fields...
                ]);
            }
    
            $storedOTP = $request->session()->get('otp');
    
            if ($storedOTP == $request->otp) {
                $token = $user->createToken('auth_token')->plainTextToken;
    
                // Clear the OTP from the session after successful login
                $request->session()->forget('otp');
    
                return response([
                    'token' =>  $token,
                    'message' => 'User logged in successfully.'
                ], 200);
            }
    
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
    
        } catch(Exception $e) {
            return response([
                'errors' => $e->message(),
                'message' => "Internal Server Error.",
            ], 500);
        }
    }
    
}
