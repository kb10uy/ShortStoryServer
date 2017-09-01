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

    public function show()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
            'include_posts' => [
                'nullable',
                'string',
                Rule::in(['', 'none', 'meta', 'full']),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Your request was incorrect.'], 400);
        }
        $bookmark = Bookmark::find((int)$this->request->input('id'));
        if (!$bookmark) {
            return response()->json([ 'error' => 'The bookmark doesn\'t exist.'], 404);
        }

        $type = $this->request->input('include_posts', 'none');
        switch ($type) {
            case 'none':
                break;
            case 'meta':
                break;
        }

        $bookmark->user;
        return $bookmark->toArray();
    }

    public function list()
    {
        $bookmarks = Bookmark::all();
        foreach ($bookmarks as $bookmark) {
            $bookmark->user;
        }
        return $bookmarks->toArray();
    }

    public function add()
    {
        $validator = Validator::make($this->request->all(), [
            'bookmark_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Your request was incorrect.'], 400);
        }
        $bookmark = Bookmark::find($this->request->input('bookmark_id'));
        if (!$bookmark) {
            return response()->json(['error' => 'That bookmark does not exist.'], 404);
        }
        if ($bookmark->user->id != Auth::user()->id) {
            return response()->json(['error' => 'That bookmark is not yours.'], 403);
        }
        $post = Post::find($this->request->input('post_id'));
        if (!$post) {
            return response()->json(['error' => 'That post does not exist.'], 404);
        }

        if ($bookmark->posts->first(function ($value) use ($post) {
            return $value->id == $post->id;
        })) {
            return response()->json(['error' => 'That post already exists in the bookmark.'], 409);
        }

        $bookmark->posts()->attach($post->id);
        return response()->json([
            'result' => 'Added.',
        ], 200);
    }

    public function pluck()
    {
        $validator = Validator::make($this->request->all(), [
            'bookmark_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Your request was incorrect.'], 400);
        }
        $bookmark = Bookmark::find($this->request->input('bookmark_id'));
        if (!$bookmark) {
            return response()->json(['error' => 'That bookmark does not exist.'], 404);
        }
        if ($bookmark->user->id != Auth::user()->id) {
            return response()->json(['error' => 'That bookmark is not yours.'], 403);
        }
        $post = Post::find($this->request->input('post_id'));
        if (!$post) {
            //無くてもエントリ削除だけしてあげるのよ
            $bookmark->posts()->detach($this->request->input('post_id'));
            return response()->json(['result' => 'That post was not found.'], 404);
        }

        $bookmark->posts()->detach($post->id);
        return response()->json([
            'result' => 'Plucked.',
        ], 200);
    }
}
