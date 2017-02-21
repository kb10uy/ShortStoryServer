<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
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
        return view('user.profile', [
            'user' => User::where('name', $user)->firstOrFail(),
        ]);
    }
    
    public function setting()
    {
        return view('user.setting');
    }
}