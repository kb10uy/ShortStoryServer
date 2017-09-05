<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Post;
use App\Bookmark;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Bookmark as BookmarkResource;
use App\Http\Resources\BookmarkEntry as BookmarkEntryResource;
use App\Http\Resources\Post as PostResource;
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
        $data = $this->request->validate([
            'id' => 'required|integer',
        ]);

        $bookmark = Bookmark::with('user')->find((int)$data['id']);
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }

        return new BookmarkResource($bookmark);
    }

    public function entries()
    {
        $data = $this->request->validate([
            'id' => 'required|integer',
            'include_posts' => 'nullable|boolean',
            'page' => 'nullable|integer',
            'count' => 'nullable|integer',
        ]);

        $bookmark = Bookmark::find((int)$data['id']);
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }

        $count = $data['count'] ?? 20;
        $entries = $bookmark->entries();
        if ($data['include_posts']) {
            $entries->with('post.user');
        }
        return BookmarkEntryResource::collection($entries->paginate($count));
    }

    public function list()
    {
        $data = $this->request->validate([
            'page' => 'nullable|integer',
            'count' => 'nullable|integer',
        ]);

        $count = $data['count'] ?? 20;
        $bookmarks = Bookmark::with('user')->paginate($count);

        return BookmarkResource::collection($bookmarks);
    }

    public function add()
    {
        $data = $this->request->validate([
            'bookmark_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);

        $bookmark = Bookmark::find($data['bookmark_id']);
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }
        if ($bookmark->user->id != Auth::user()->id) {
            return response()->jsonError(__('message.api.bookmark_not_yours'), 403);
        }
        $post = Post::find($data['post_id']);
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
        $data = $this->request->validate([
            'bookmark_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);

        $bookmark = Bookmark::find($data['bookmark_id']);
        if (!$bookmark) {
            return response()->jsonError(__('message.api.bookmark_not_found'), 404);
        }
        if ($bookmark->user->id != Auth::user()->id) {
            return response()->jsonError(__('message.api.bookmark_not_yours'), 403);
        }
        $post = Post::find($data['post_id']);
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }

        $bookmark->removePostByInstance($post);
        return response()->jsonResult(__('message.api.bookmark_plucked'), 200);
    }
}
