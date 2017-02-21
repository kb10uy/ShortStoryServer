<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;

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
        //$this->middleware('guest', ['except' => ['logout']]);
    }
    
    public function username() {
        return 'name';
    }
    
    /*
    //Socialite
    public function redirectToTwitter() 
    {
        return Socialite::driver('twitter')->redirect();
    }
    
    public function handleTwitterCallback() 
    {
        if (Auth::check()) {
            //return $this->handleUpdateSocialiteUser('twitter', $request);
        } else {
            //return $this->handleNewSocialiteUser('twitter', $social);
        }
    }
    
    public function redirectToGitHub() 
    {
        return Socialite::driver('github')->redirect();
    }
    
    public function handleGitHubCallback() 
    {
        if (Auth::check()) {
            return "ログイン済みなんだが？";
            //return $this->handleUpdateSocialiteUser('github', $request);
        } else {
            return "まだログインしてないんだが？";
            //return $this->handleNewSocialiteUser('github', $request, $social);
        }
    }
    
    //新規ユーザーログイン
    protected function handleNewSocialiteUser($driver, $request, $social) 
    {
        $session = $request->session();
        
        $session->put($driver . '_id', $social->getId());
        $session->put($driver . '_name', $social->getNickname());
        
        $session->flash('information', 'You are registering with ' . $driver . ' account. Your account name is ' . $social->getName() . '.');
        return redirect()->route('register');
    }
    
    //ログイン済みユーザーのアップデート
    protected function handleUpdateSocialiteUser($driver, $request) 
    {
        $curuser = Auth::user();
        $socuser = Socialite::driver($driver)->user();
        $curuser->fill([
            $driver . '_id' => $socuser->getId(), 
            $driver . '_name' => $socuser->getNickname(), 
        ])->save();
        
        $request->session()->flash('updated', 'Twitter account information has been successfully updated!');
        return redirect()->route('user.setting');
    }
    */
}
