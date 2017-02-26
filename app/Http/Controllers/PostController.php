<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Post;

class PostController extends Controller
{
    //
    public function create()
    {
        return view('post.new');
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:128',
            'text' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('posts.new')
                ->withErrors($validator)
                ->withInput();
        }
        $post = new Post;
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user = Auth::user();
        $post->save();
        Session::flash('success', 'Your post has been uploaded successfully!');
    }
}
