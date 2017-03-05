<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
use Session;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        //そりゃお前ログイン済みでしょ
        $this->middleware('auth')->except('profile');
    }
    
    public function profile($user)
    {
        $user = User::where('name', $user)->first();
        if (!$user) {
            Session::flash('alert', __('view.message.user_not_exist'));
            return redirect()->route('home');
        }
        return view('user.profile', ['user' => $user]);
    }
    
    public function setting()
    {
        return view('user.setting');
    }
}