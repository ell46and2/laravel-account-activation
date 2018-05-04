<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    public function activate()
    {
    	$user = User::ByActivationColumns(request()->email, request()->token)
    		->firstOrFail();

    	$user->update([
    		'active' => true,
    		'activation_token' => null
    	]);

    	Auth::loginUsingId($user->id);

    	return redirect()->route('home')->withSuccess('Activated! You\'re now signed in.');
    }	
}
