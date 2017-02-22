<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
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
    
    
    //Socialite
    
    
    public function redirectToTwitter() 
    {
        return Socialite::driver('twitter')->redirect();
    }
    
    public function handleTwitterCallback(Request $request) 
    {
        $social = Socialite::driver('twitter')->user();
        $state = $request->get('state');
        $request->session()->put('state',$state);
        $request->session()->regenerate();
        
        if (Auth::check()) {
            return $this->handleUpdateSocialiteUser('twitter', $request, $social);
        } else {
            return $this->handleNewSocialiteUser('twitter', $request->session(), $social);
        }
    }
    
    public function removeTwitterData(Request $request)
    {
        $user = Auth::user();
        $user->fill([
            'twitter_id' => 0,
            'twitter_name' => '',
        ])->save();
        
        $request->session()->flash('updated', 'Your twitter account information has been successfully deleted!');
        return back();
    }
    
    public function redirectToGitHub() 
    {
        return Socialite::driver('github')->redirect();
    }
    
    public function handleGitHubCallback(Request $request) 
    {
        $social = Socialite::driver('github')->user();
        //$state = $request->get('state');
        //$request->session()->put('state',$state);
        //$request->session()->regenerate();
        
        if (Auth::check()) {
            return $this->handleUpdateSocialiteUser('github', $request, $social);
        } else {
            return $this->handleNewSocialiteUser('github', $request->session(), $social);
        }
    }
    
    public function removeGitHubData(Request $request)
    {
        $user = Auth::user();
        $user->fill([
            'github_id' => 0,
            'github_name' => '',
        ])->save();
        
        $request->session()->flash('updated', 'Your GitHub account information has been successfully deleted!');
        return back();
    }
    
    //新規・既存ユーザーログイン
    protected function handleNewSocialiteUser($driver, $session, $social) 
    {
        $user = User::where($driver . '_id', $social->getId())->first();
        if ($user) {
            Auth::login($user);
            $user.fill([$driver . '_name' => $social->getNickname()])->save();
            return redirect()->route('home');
        } else {
            $session->put($driver . '_id', $social->getId());
            $session->put($driver . '_name', $social->getNickname());
            
            $session->flash('information', 'You are registering with ' . $driver . ' account. Your account name is ' . $social->getNickname() . '.');
            return redirect()->route('register');
        }
    }
    
    
    //ログイン済みユーザーのアップデート
    protected function handleUpdateSocialiteUser($driver, $request, $social) 
    {
        $curuser = Auth::user();
        $user = User::where($driver . '_id', $social->getId())->first();
        if ($user && !$user->is($curuser)) {
            //使用済み
            $request->errors()->add('github', 'The ' . $driver . ' account you authorized is already used by another user!');
            return redirect()->route('user.setting');
        }
        
        $curuser->fill([
            $driver . '_id' => $social->getId(), 
            $driver . '_name' => $social->getNickname(), 
        ])->save();
        
        $request->session()->flash('updated', 'Your ' . $driver . ' account information has been successfully updated!');
        return redirect()->route('user.setting');
    }
}
