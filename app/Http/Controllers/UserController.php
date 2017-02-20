<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        //そりゃお前ログイン済みでしょ
        $this->middleware('auth');
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