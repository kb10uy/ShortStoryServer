<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
use App\User;
use App\Post;
use App\Bookmark;

class UserController extends Controller
{
    protected $postsToShowInProfile = 5;
    protected $bookmarksToShowInProfile = 5;
    public $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
        //そりゃお前ログイン済みでしょ
        $this->middleware('auth')->except('profile');
    }
    
    public function profile($user)
    {
        $user = User::where('name', $user)->first();
        if (!$user) {
            session()->flash('alert', __('view.message.user_not_exist'));
            return redirect()->route('home');
        }
        //visibleクエリが必要なので動的プロパティ使用不可？
        $posts = Post::where('user_id', $user->id)->visible()->latest()->take($this->postsToShowInProfile)->get();
        $bookmarks = Bookmark::where('user_id', $user->id)->visible()->latest()->take($this->bookmarksToShowInProfile)->get();

        return view('user.profile', [
            'user' => $user,
            'posts' => $posts,
            'bookmarks' => $bookmarks,
        ]);
    }
    
    public function setting()
    {
        return view('user.setting');
    }
}