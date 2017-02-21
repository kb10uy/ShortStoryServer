<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        //そりゃお前ログイン済みでしょ
        $this->middleware('auth')->except('profile');
    }
    
    public function profile()
    {
        return view('user.profile');
    }
    
    public function setting()
    {
        return view('user.setting');
    }
}