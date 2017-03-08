<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
use Session;
use App\User;
use App\Post;

class UserController extends Controller
{
    protected $postsToShowInProfile = 5;

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
        $posts = Post::where('user_id', $user->id)->visible()->latest()->take($this->postsToShowInProfile)->get();

        return view('user.profile', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
    
    public function setting()
    {
        return view('user.setting');
    }
}