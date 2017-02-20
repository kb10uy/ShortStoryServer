<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

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

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function username() {
        return 'name';
    }
    
    //Socialite
    public function redirectToTwitter() {
        return Socialite::driver('twitter')->redirect();
    }
    
    public function handleTwitterCallback() {
        //return Socialite::driver('twitter')->redirect();
    }
    
    public function redirectToGitHub() {
        return Socialite::driver('github')->redirect();
    }
    
    public function handleGitHubCallback() {
        //return Socialite::driver('github')->redirect();
    }
}
