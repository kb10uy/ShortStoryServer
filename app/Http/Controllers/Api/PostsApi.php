<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Post;
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
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$this->request->input('id'));
        if (!$post) return response()->json(['error' => 'The post doesn\'t exist.'], 404);
        //リレーション読み込み
        $post->user;
        $post->tags;

        return $post->toArray();
    }

    public function list()
    {
        $posts = Post::all();
        foreach($posts as $post) {
            $post->user;
            $post->tags;
        }

        return $posts->toArray();
    }

    public function nice()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$this->request->input('id'));
        if (!$post) return response()->json(['error' => 'The post doesn\'t exist.'], 404);
        $post->performNice();
        return response()->json([
            'result' => 'Niced.',
            'nice_count' => (int) ($post->info())['nice_count'],
        ], 200);
    }

    public function bad()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$this->request->input('id'));
        if (!$post) return response()->json(['error' => 'The post doesn\'t exist.'], 404);
        $post->performBad();
        return response()->json([
            'result' => 'Badded.',
            'bad_count' => (int) ($post->info())['bad_count'],
        ], 200);
    }

    public function dopyulicate() 
    {
         $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$this->request->input('id'));
        if (!$post) return response()->json(['error' => 'The post doesn\'t exist.'], 404);
        $post->performDopyulicate();
        return response()->json([
            'result' => 'Dopyulicated.',
        ], 200);
    }

}