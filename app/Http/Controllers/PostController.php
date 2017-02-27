<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Post;
use Auth;
use Session;

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
        Auth::user()->posts()->save($post);
        Session::flash('success', 'Your post has been uploaded successfully!');

        return redirect()->route('post.view', ['id' => $post->id]);
    }

    public function open(Request $request, $id) 
    {
        $post = Post::find($id);
        if (!$post) {
            Session::flash('alert', 'This post has been deleted or doesn\'t exist!');
        } elseif ($post->invisible) {
            Session::flash('warning', 'This post is set invisible now.');
        }
        return view('post.view', ['post' => $post]);
    }
}
