<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /*
        overwrite resetPassword method from ResetsPasswords trait
        to stop unauthenticated users from getting automatically
        signed in when they reset their passwords.
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(str_random(60));

        $user->save();

        event(new PasswordReset($user));

        if($user->active) {
            $this->guard()->login($user);
        }       
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
            ->withSuccess('Your password has been reset successfully.');
    }
}
