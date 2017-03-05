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

class PostController extends Controller
{
    public $paginationCount = 10;

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
        $post->fill([
            'title' => $request->title,
            'text' => $request->text,
        ]);
        //$postを先にsaveしないとidが確定しないのでpost_tagのpost_idがわからなくなる
        Auth::user()->posts()->save($post);
        $post->tags()->sync($tagids);
        Redis::zincrby(config('database.keys.post-views'), 0, $post->id);
        Redis::zincrby(config('database.keys.post-nices'), 0, $post->id);
        Redis::zincrby(config('database.keys.post-bads'), 0, $post->id);

        Session::flash('success', __('view.message.post_uploaded'));
        return redirect()->route('post.view', ['id' => $post->id]);
    }

    public function edit(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            Session::flash('alert', __('view.message.post_not_exist'));
            return redirect()->route('home');
        } elseif (Auth::user()->cant('update', $post)) {
            Session::flash('alert', __('view.message.post_cant_edit'));
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
            Session::flash('alert', __('view.message.post_not_exist'));
            return redirect()->route('home');
        } elseif (Auth::user()->cant('update', $post)) {
            Session::flash('alert', __('view.message.post_cant_edit'));
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
            Session::flash('alert', __('view.message.post_not_exist'));
        } elseif ($post->invisible) {
            Session::flash('warning', __('view.message.post_invisible'));
        }

        Redis::zincrby(config('database.keys.post-views'), 1, $post->id);
        return view('post.view', [
            'post' => $post,
            'parsed' => Text::parse('s3wf', $post->text),
        ]);
    }

    // /post?sort=****&.... (GET)
    // pageクエリは勝手に探して判断してくれるよ！
    public function list(Request $request)
    {
        $posts = Post::visible();
        if ($request->has('sort')) {
            switch($request->input('sort')) {
                case 'view':
                    $posts = $posts->orderBy('view_count', 'desc');
                    break;
                case 'nice':
                    $posts = $posts->orderBy('nice_count', 'desc');
                    break;
                case 'bookmark':
                    $posts = $posts->orderBy('bookmark_count', 'desc');
                    break;
                case 'updated':
                    $posts = $posts->latest('updated_at', 'desc');
                    break;
                case 'created':
                default:
                    $posts = $posts->latest();
                    break;
            }
        } else {
            $posts = $posts->latest();
        }
        $posts = $posts->paginate(10);
        return view('post.list', [
            'posts' => $posts,
        ]);
    }
}
