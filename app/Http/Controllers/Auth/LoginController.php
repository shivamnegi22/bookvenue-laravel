<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\Authenticatesusers;
use Illuminate\Support\Facades\Crypt;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Session;
use App\MSG91;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use Authenticatesusers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }
  
public function login(Request $request)
{
   
    $request->validate([
        'phone' => 'required|digits:10', 
    ]);

    
    $user = user::where('phone', $request->{$this->username()})->first();

    if ($user) {

    $otp = mt_rand(100000, 999999);

    Session::forget('OTP');

    Session::forget('phone');

    Session::put('OTP', $otp);

    Session::put('phone', $request->{$this->username()});

    $MSG91 = new MSG91();

    $MSG91->sendDltSms('62385ab87f0231333a04e445', '91'.$request->phone, 'OTP', [$otp]);

    return view('Auth.verify-otp');

    }

    else
    {
        return back()->withErrors(['otp' => 'Invalid phoneno']);
    }
}

public function verifyOTP(Request $request)
{

    $request->validate([
 
        'otp' => 'required|digits:6', 
    ]);

    $savedOTP = Session::get('OTP');

    $phone = Session::get('phone');

    if ($savedOTP == $request->otp) {

        $user = user::where('phone', $phone)->first();

        Auth::login($user);
        
        $user = Auth::user(); 

        if ($user->hasAnyRoles(['admin', 'vendor', 'helpdesk', 'manager'])) {
          
            return redirect('dashboard');

        } else {
     
            return redirect('dashboard');
        }
    } 
    else {
      
        return back()->withErrors(['otp' => 'Invalid OTP']);
    }
}

}
