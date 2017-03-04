<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Post;
use App\Tag;
use Auth;
use Session;

class PostController extends Controller
{
    // /post/new (GET)
    public function create()
    {
        return view('post.new');
    }

    // /post/new (POST)
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:128',
            'text' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('post.new')
                ->withErrors($validator)
                ->withInput();
        }
        //dd('[' . $request->tags . ']');
        $tags = eval('return [' . $request->tags . '];');
        $tagids = [];
        foreach ($tags as $tagname) {
            $tag = Tag::firstOrCreate(['name' => $tagname]);
            $tagids[] = $tag->id;
        }

        $post = new Post;
        $post->title = $request->title;
        $post->text = $request->text;
        //$postを先にsaveしないとidが確定しないのでpost_tagのpost_idがわからなくなる
        Auth::user()->posts()->save($post);
        $post->tags()->sync($tagids);

        Session::flash('success', 'Your post has been uploaded successfully!');
        return redirect()->route('post.view', ['id' => $post->id]);
    }

    public function edit(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            Session::flash('alert', 'This post has been deleted or doesn\'t exist!');
            return redirect()->route('home');
        } elseif (Auth::user()->cant('update', $post)) {
            Session::flash('alert', 'You can\'t edit this post!');
            return redirect()->route('home');
        }

        $taglist = json_encode($post->tags->map(function($item,$key) {
            return $item->name;
        }));
        return view('post.edit', [
            'post' => $post,
            'taglist' => $taglist,
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:128',
            'text' => 'required',
        ]);

        if (!$post) {
            Session::flash('alert', 'This post has been deleted or doesn\'t exist!');
            return redirect()->route('home');
        } elseif (Auth::user()->cant('update', $post)) {
            Session::flash('alert', 'You can\'t edit this post!');
            return redirect()->route('home');
        } elseif ($validator->fails()) {
            return redirect()->route('post.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $tags = eval('return [' . $request->tags . '];');
        $tagids = [];
        foreach ($tags as $tagname) {
            $tag = Tag::firstOrCreate(['name' => $tagname]);
            $tagids[] = $tag->id;
        }
        $post->fill([
            'title' => $request->title,
            'text' => $request->text,
        ])->save();
        $post->tags()->sync($tagids);

        return redirect()->route('post.view', ['id' => $post->id]);
    }

    // /post/{id} (GET)
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
