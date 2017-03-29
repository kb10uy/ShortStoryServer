<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Bookmark;

class BookmarkController extends Controller
{
    public $paginationCount = 10;

    // ユーザー名で一覧する
    public function listUser(Request $request, $name)
    {
        $user = User::where('name', $name)->first();
        if (!$user) {
            Session::flash('alert', __('view.message.user_not_exist'));
            return redirect()->route('home');
        }
        //visibleクエリが必要なので動的プロパティ使用不可？
        $bookmarks = Bookmark::where('user_id', $user->id)
            ->visible()
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginationCount);
        
        return view('bookmark.list-user', [
            'user' => $user,
            'bookmarks' => $bookmarks,
        ]);
    }

    //特定ブクマのPost一覧
    public function view(Request $request, $id)
    {
        $bookmark = Bookmark::find($id);
        if (!Bookmark::visibleForMe($bookmark, $response)) return $response;

        $posts = $bookmark->posts->filter(function($item, $key) {
            return $item->visibleNow();
        });
        return view('bookmark.view', [
            'bookmark' => $bookmark,
            'posts' => $posts,
        ]);
    }
}
