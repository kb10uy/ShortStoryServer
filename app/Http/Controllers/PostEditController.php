<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Post;
use App\Tag;
use Auth;
use Session;
use Text;
use Redis;
use Carbon\Carbon;

class PostEditController extends Controller
{
    // /post/new (GET)
    public function create()
    {
        return view('post.new');
    }

    // /post/new (POST)
    public function upload(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:128',
            'text' => 'required',
        ]);
        
        $tags = eval('return [' . $request->tags . '];');
        $tagids = [];
        foreach ($tags as $tagname) {
            $tag = Tag::firstOrCreate(['name' => $tagname]);
            $tagids[] = $tag->id;
        }

        $post = new Post;
        $post->fill([
            'title' => $request->title,
            'text' => $request->text,
            'type' => $request->type,
            'modified_at' => Carbon::now(),
        ]);
        //$postを先にsaveしないとidが確定しないのでpost_tagのpost_idがわからなくなる
        Auth::user()->posts()->save($post);
        $post->tags()->sync($tagids);
        $post->initInfo();

        Session::flash('success', __('view.message.post_uploaded'));
        return redirect()->route('post.view', ['id' => $post->id]);
    }

    // /post/{id}/edit (GET)
    public function edit(Request $request, $id)
    {
        $post = Post::find($id);
        if (!Post::updatable($post, $response)) return $response;
        
        $taglist = json_encode($post->tags->map(function($item,$key) {
            return $item->name;
        }));
        return view('post.edit', [
            'post' => $post,
            'taglist' => $taglist,
        ]);
    }

    // /post/{id}/edit (PATCH)
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!Post::updatable($post, $response)) return $response;
        $this->validate($request, [
            'title' => 'required|max:128',
            'text' => 'required',
            'type' => 'required',
        ]);

        $tags = eval('return [' . $request->tags . '];');
        $tagids = [];
        foreach ($tags as $tagname) {
            $tag = Tag::firstOrCreate(['name' => $tagname]);
            $tagids[] = $tag->id;
        }
        $post->fill([
            'title' => $request->title,
            'text' => $request->text,
            'type' => $request->type,
            'modified_at' => Carbon::now(),
        ]);
        $post->save();
        $post->tags()->sync($tagids);

        return redirect()->route('post.view', ['id' => $post->id]);
    }

    // /post/{id}/delete (DELETE)
    public function delete(Request $request, $id) {
        $post = Post::find($id);
        if (!Post::updatable($post, $response)) return $response;
        
        $post->delete();
        Session::flash('success', __('view.message.post_deleted'));
        return redirect()->route('home');
    }
}