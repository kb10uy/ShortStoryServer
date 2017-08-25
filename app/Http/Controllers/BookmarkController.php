<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use App\Post;
use App\Bookmark;
use Auth;

class BookmarkController extends Controller
{
    public $paginationCount = 10;
    public $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // ユーザー名で一覧する
    public function listUser($name)
    {
        $user = User::where('name', $name)->first();
        if (!$user) {
            $this->session()->flash('alert', __('view.message.user_not_exist'));
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

    // /bookmark/{id} (GET)
    // 特定ブクマのPost一覧
    public function view($id)
    {
        $bookmark = Bookmark::find($id);
        if (!Bookmark::visibleForMe($bookmark, $response)) {
            $this->session()->flash('alert', __('view.message.bookmark_protected'));
            return redirect()->route('home');
        }

        $posts = $bookmark->posts->filter(function ($item, $key) {
            return $item->visibleNow();
        });
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new LengthAwarePaginator(
            $posts->forPage($page, $this->paginationCount),
            $posts->count(),
            $this->paginationCount,
            $page,
            ['path' => $this->request->url(), 'query' => $this->request->query()]
        );
        return view('bookmark.view', [
            'bookmark' => $bookmark,
            'posts' => $paginated,
        ]);
    }

    // get 登録確認画面
    public function showAddView($id)
    {
    }

    // patch 登録する
    public function addToBookmark()
    {
    }

    // get 作成画面
    public function showCreateView()
    {
        return view('bookmark.create');
    }

    // post 作成する
    public function create()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'description' => 'max:512',
            //'protected' => 'required',
        ]);

        $bookmark = Bookmark::create([
            'name' => $this->request->name,
            'description' => $this->request->description,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('bookmark.view', ['id' => $bookmark->id]);
    }
}
