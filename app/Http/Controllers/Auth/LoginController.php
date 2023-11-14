<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Session;
use App\MSG91;
use Illuminate\Support\Facades\Hash;
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

    use AuthenticatesUsers;

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
        'password' => 'required',
    ]);

    
    $user = User::where('phone', $request->{$this->username()})->first();

    

    if ($user) {

        // dd($request->password);

        if (Hash::check($request->password,$user->password)) {

            
            // Check if the user has any of the specified roles
            Auth::login($user);

            $user = Auth::user(); 

            if ($user->hasAnyRoles(['admin', 'vendor', 'helpdesk', 'manager'])) {

                
                return redirect('dashboard');
            } else {
                
                return redirect('user_dashboard');
            }
    
    }

    else
    {
        return back()->withErrors(['otp' => 'Invalid password']);
    }
    
    }
    else
    {
        return back()->withErrors(['otp' => 'Phone no does not exist']);
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

        $user = User::where('phone', $phone)->first();

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

public function logout(Request $request) {
  
    Auth::logout();
    return redirect('/');
  }

}
