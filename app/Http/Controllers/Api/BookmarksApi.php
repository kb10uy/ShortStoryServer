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
        ]);
        if ($validator->fails()) {
            return response()->jsonError(__('message.api.bad_request'), 400);
        }
        $bookmark = Bookmark::find((int)$this->request->input('id'));
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }

        $type = $this->request->input('include_posts', 'none');
        $bookmark->user;
        return $bookmark->toArray();
    }

    public function entries()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
            'include_posts' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->jsonError(__('message.api.bad_request'), 400);
        }
        $bookmark = Bookmark::find((int)$this->request->input('id'));
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }
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
            return response()->jsonError(__('message.api.bad_request'), 400);
        }
        $bookmark = Bookmark::find($this->request->input('bookmark_id'));
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }
        if ($bookmark->user->id != Auth::user()->id) {
            return response()->jsonError(__('message.api.bookmark_not_yours'), 403);
        }
        $post = Post::find($this->request->input('post_id'));
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }

        $result = $bookmark->registerPost($post);
        if ($result === false) {
            return response()->jsonError(__('message.api.bookmark_already_exists'), 409);
        }

        return response()->jsonResult(__('message.api.bookmark_added'), 200);
    }

    public function pluck()
    {
        $validator = Validator::make($this->request->all(), [
            'bookmark_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->jsonError(__('message.api.bad_request'), 400);
        }
        $bookmark = Bookmark::find($this->request->input('bookmark_id'));
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }
        if ($bookmark->user->id != Auth::user()->id) {
            return response()->jsonError(__('message.api.bookmark_not_yours'), 403);
        }
        $post = Post::find($this->request->input('post_id'));
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }

        $bookmark->removePostByInstance($post);
        return response()->jsonResult(__('message.api.bookmark_plucked'), 200);
    }
}
