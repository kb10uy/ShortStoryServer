<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Bookmark as BookmarkResource;
use App\Http\Resources\Post as PostResource;

use App\User;
use Auth;
use Validator;

class UsersApi extends Controller
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

        $user = User::find((int)$data['id']);
        if (!$user) {
            return response()->jsonError(__('message.api.user_not_found'), 404);
        }

        return new UserResource($user);
    }

    public function bookmarks()
    {
        $data = $this->request->validate([
            'user_id' => 'required|integer',
            'page' => 'nullable|integer',
            'count' => 'nullable|integer',
        ]);
        $user = User::find((int)$data['user_id']);
        if (!$user) {
            return response()->jsonError(__('message.api.user_not_found'), 404);
        }

        $count = $data['count'] ?? 20;
        $bookmarks = $user->bookmarks()->paginate($count);
        return BookmarkResource::collection($bookmarks);
    }

    public function posts()
    {
        $data = $this->request->validate([
            'user_id' => 'required|integer',
            'page' => 'nullable|integer',
            'count' => 'nullable|integer',
        ]);
        $user = User::find((int)$this->request->input('user_id'));
        if (!$user) {
            return response()->jsonError(__('message.api.user_not_found'), 404);
        }

        $count = $data['count'] ?? 20;
        $posts = $user->posts()->paginate($count);
        return PostResource::collection($posts);
    }
}
