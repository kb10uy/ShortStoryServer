<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Post;
use App\Http\Resources\Post as PostResource;
use Auth;
use Validator;

class PostsApi extends Controller
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

        $post = Post::find((int)$data['id']);
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }
        //リレーション読み込み
        $post->user;
        $post->tags;

        return new PostResource($post);
    }

    public function list()
    {
        $data = $this->request->validate([
            'page' => 'nullable|integer',
            'count' => 'nullable|integer',
        ]);

        $count = $data['count'] ?? 20;
        $posts = Post::with(['user', 'tags'])->paginate($count);
        foreach ($posts as $post) {
            $post->user;
            $post->tags;
        }

        return PostResource::collection($posts);
    }

    public function nice()
    {
        $data = $this->request->validate([
            'id' => 'required|integer',
        ]);

        $post = Post::find((int)$data['id']);
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }
        $post->performNice();
        return response()->json([
            'result' => 'Niced.',
            'nice_count' => (int) ($post->info())['nice_count'],
        ], 200);
    }

    public function bad()
    {
        $data = $this->request->validate([
            'id' => 'required|integer',
        ]);

        $post = Post::find((int)$data['id']);
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }
        $post->performBad();
        return response()->json([
            'result' => 'Badded.',
            'bad_count' => (int) ($post->info())['bad_count'],
        ], 200);
    }

    public function dopyulicate()
    {
        $data = $this->request->validate([
            'id' => 'required|integer',
        ]);

        $post = Post::find((int)$data['id']);
        if (!$post) {
            return response()->jsonError(__('message.api.post_not_found'), 404);
        }
        $post->performDopyulicate();
        return response()->json([
            'result' => 'Dopyulicated.',
        ], 200);
    }
}
