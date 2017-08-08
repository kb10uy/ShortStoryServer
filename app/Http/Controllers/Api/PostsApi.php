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

    /* 
     * /posts/get (GET)
     * id(required): 取得したい投稿のid
     * 
     * 指定したidを持つ投稿の全ての情報を取得します。
     */
    public function get()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$request->input('id'));
        if (!$post) return response()->json([ 'error' => 'The post doesn\'t exist.'], 404);
        return response()->json($post, 200);
    }

    /* 
     * /posts/nice (PATCH)
     * id(required): 取得したい投稿のid
     * 
     * 指定したidを持つ投稿にいいねします。
     */
    public function nice()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$this->request->input('id'));
        if (!$post) return response()->json([ 'error' => 'The post doesn\'t exist.'], 404);
        $post->performNice();
        return response()->json([
            'result' => 'Niced.',
            'nice_count' => ($post->info())['nice_count'],
        ], 200);
    }

    /*
     * /posts/dopyulicate (POST)
     * id(required): シコった投稿のid
     *
     * 指定したidの投稿にシコりメールを送ります。
     */
    public function dopyulicate() 
    {
         $validator = Validator::make($this->request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$this->request->input('id'));
        if (!$post) return response()->json([ 'error' => 'The post doesn\'t exist.'], 404);
        $post->performDopyulicate();
        return response()->json([
            'result' => 'Dopyulicated.',
        ], 200);
    }

}