<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Rules\ValidRecaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Setting;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


 

        
    // Overriding method of Illuminate\Foundation\Auth\AuthenticatesUsers;
    public function showLoginForm()
    {

        // Logging out the other type of user - Customer (just in case)
        // Auth::logout();

        return view('auth.login');
    }

    // Overriding method of Illuminate\Foundation\Auth\AuthenticatesUsers;
    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username()   => 'required|string',
            'password'          => 'required|string',
        ];

        if(is_recaptcha_enable())
        {
            $rules['g-recaptcha-response'] = ['required', new ValidRecaptcha];
        }

        $this->validate($request, $rules);

    }


     public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if(Auth::guard('customer')->attempt([
            'email' => $request->email, 'password' => $request->password ], $request->remember))
        {
             Auth::guard('web')->logout();
            return redirect()->intended(route('customer_dashboard'));
        }

        // return redirect()->back()->withInput($request->only('email', 'remember'))
        // ->withErrors(['email' => 'These credentials does not match our records.']);


        error_log("overriding");
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


}
