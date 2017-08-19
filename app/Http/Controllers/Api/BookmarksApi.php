<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Post;
use App\Bookmark;
use Auth;
use Validator;

class BookmarksApi extends Controller
{
    public $request = null;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /* 
     * /bookmarks/list (GET)
     * 
     * 指定したidを持つ投稿の全ての情報を取得します。
     */
    public function list() {
        $bookmarks = Auth::user()->bookmarks;

        return $bookmarks->toJson();
    }

    /*
     * /bookmarks/add (PATCH)
     * 
     * 追加します。
     *  
     */
    public function add() {
        $validator = Validator::make($this->request->all(), [
            'bookmark_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set ids.'], 400);
        
        $bookmark = Bookmark::find($this->request->input('bookmark_id'));
        if (!$bookmark)  return response()->json(['error' => 'That bookmark does not exist.'], 404);
        if ($bookmark->user->id != Auth::user()->id) return response()->json(['error' => 'That bookmark is not yours.'], 403);
        $post = Post::find($this->request->input('post_id'));
        if (!$post)  return response()->json(['error' => 'That post does not exist.'], 404);
        if ($bookmark->posts->first(function($value) use($post) { return $value->id == $post->id; })) {
            return response()->json(['error' => 'That post already exists in the bookmark.'], 409);
        }
        $bookmark->posts()->attach($post->id);
        return response()->json([
            'result' => 'Added.',
        ], 200);
    }
}