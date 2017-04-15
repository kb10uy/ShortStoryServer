<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Post;
use Auth;
use Session;
use Validator;

class PostsApi extends Controller
{
    /* 
     * /posts/get (GET)
     * id(required): 取得したい投稿のid
     * 
     * 指定したidを持つ投稿の全ての情報を取得します。
     */
    public function get(Requset $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$request->input('id'));
        if (!$post) return response()->json([ 'error' => 'The post doesn\'t exist.'], 404);
        return response()->json($post, 200);
    }

    /* 
     * /posts/nice (patch)
     * id(required): 取得したい投稿のid
     * 
     * 指定したidを持つ投稿にいいねします。
     */
    public function nice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'You should set id.'], 400);

        $post = Post::find((int)$request->input('id'));
        if (!$post) return response()->json([ 'error' => 'The post doesn\'t exist.'], 404);
        $post->performNice();
        return response()->json([
            'result' => 'Niced.',
            'nice_count' => ($post->info())['nice_count'],
        ], 200);
    }
}