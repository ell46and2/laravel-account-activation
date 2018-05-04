<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivationResendFormRequest;
use App\User;
use Illuminate\Http\Request;

class ActivationResendController extends Controller
{
    public function showResendForm()
    {
    	return view('auth.activate.resend');
    }

    public function resend(ActivationResendFormRequest $request)
    {
    	$user = User::byEmail($request->email)->first();

    	event(new UserRequestedActivationEmail($user));

    	return redirect()->route('login')
    		->withSuccess('Account activation email has been resent.');
    }
}
