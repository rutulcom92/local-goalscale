<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Events\GoalEvents;

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

     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    public function showLandingPage(Request $request)
    {
        return view('landing');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!empty($user)) {

            if(Auth::user()->is_active == 0){
                $this->guard()->logout();
                return $this->loggedOut($request) ?: redirect(route('login'))->withErrors(['auth.error' => 'Your account is no longer active.']);
            }
            else{
                Auth::user()->update(['last_login' => date('Y-m-d H:i:s')]);

                $request->event_id = 4;
                $request->related_id = Auth::user()->id;
                $request->email = $request->email;
                $request->desc = Auth::user()->full_name;
                event(new GoalEvents($request));
            }
        }
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $request->event_id = 10;
            $request->email = $request->email;
            $request->desc = $request->email;
            event(new GoalEvents($request));

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $request->event_id = 11;
        $request->email = $request->email;
        $request->desc = $request->email;
        event(new GoalEvents($request));

        //echo 'importData_arr = <pre>';print_r($request->email);echo '</pre>';
        //exit;

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request) {

        $request->event_id = 8;
        $request->related_id = Auth::user()->id;
        $request->email = $request->email;
        $request->desc = Auth::user()->full_name;
        event(new GoalEvents($request));

        Auth::logout();
        return redirect('/login');
    }
}
