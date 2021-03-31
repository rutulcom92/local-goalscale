<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;

use App\Events\GoalEvents;

class SetPasswordController extends Controller
{
    use RedirectsUsers;
    /*
    |--------------------------------------------------------------------------
    | Password set Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password set requests.
    |
    */

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password reset view for the given email.
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSetForm(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if(!empty($user->password)){
            return redirect(route('login'))->withErrors(['auth.error' => 'Your password has been already set.']);
        }
        else if($user->is_active == 0 || $user->is_active == '0'){
            return redirect(route('login'))->withErrors(['auth.error' => 'Your account is no longer active.']);
        }
        return view('auth.passwords.set')->with(
            ['email' => $request->email]
        );
    }
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $user = User::whereEmail($request->email)->first();
        $this->resetPassword($user, $request->password);

        $request->event_id = 9;
        $request->related_id = $user->id;
        $request->email = $user->email;
        $request->desc = $user->first_name.''.$user->last_name;
        event(new GoalEvents($request));

        return redirect($this->redirectPath())
                            ->with('status', trans('Password set successfully'));
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|confirmed|strong_password',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'password.strong_password' => 'Please provide atleast one uppercase, lowercase and a special character'
        ];
    }
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        if($user->is_active == '0' || $user->is_active == 0){
            return redirect()->route('login')->withErrors(['error' => 'Your account is no longer active.']);
            // return redirect(route('login'))->withErrors(['auth.error' => 'Your account is no longer active.']);
        }
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        $this->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
