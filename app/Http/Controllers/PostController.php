<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Post;
use App\Tag;
use App\Jobs\SyncPostInfoToDatabase;

use Auth;
use Session;
use Text;
use Redis;

class PostController extends Controller
{
    public $paginationCount = 10;

    // /post/{id} (GET)
    public function open(Request $request, $id) 
    {
        $post = Post::find($id);
        if (!Post::visibleForMe($post, $response)) return $response;

        Redis::zincrby(config('database.keys.post-views'), 1, $post->id);
        return view('post.view', [
            'post' => $post,
            'parsed' => Text::parse($post->type, $post->text),
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

    public function search(Request $request)
    {
        if (!$request->has('q')) return view('post.search');
        
        switch($request->input('type')) {
            case 'keyword':
                $posts = Post::search($request->input('q'))->paginate($this->paginationCount);
                break;
            case 'tag':
                $posts = $this->paginatePosts($this->getPostsOfTags($request->input('q')));
                break;
            case 'author':
                $posts = $this->paginatePosts($this->getPostsOfUsers($request->input('q')));
                break;
            default:
                $posts = Post::paginate($this->paginationCount);
                break;
        }
        dispatch(new SyncPostInfoToDatabase);
        dd($posts);
        return view('post.search', [
            'posts' => $posts,
        ]);
    }

    public function getPostsOfTags($tags)
    {
        $tags = collect(preg_split('/[\s　]/u', $query, -1, PREG_SPLIT_NO_EMPTY))
            ->map(function($item, $key) {
                return Tag::where('name', $item)->first();
            })
            ->filter()
            ->keyBy('id');
        if ($tags->count() == 0)  return collect([]);

        foreach($tags as $tag) $results = $results->intersect($tag->posts->keyBy('id'));
        return $results;
    }

    public function getPostsOfUsers($query)
    {
        $users = collect(preg_split('/[\s　]/u', $query, -1, PREG_SPLIT_NO_EMPTY))
            ->map(function($item, $key) {
                return User::where('name', $item)->first();
            })
            ->filter()
            ->keyBy('id');
        if ($users->count() == 0)  return collect([]);

        foreach($users as $user) $results = $results->union($user->posts->keyBy('id'));
        return $results;
    }

    public function paginatePosts(Request $request, $posts)
    {
        $sort = $request['sort'];
        $page = (int)$request['page'];
        switch($sort) {
            case 'view':
                $posts = $posts->sortByDesc('view_count');
                break;
            case 'nice':
                $posts = $posts->sortByDesc('nice_count');
                break;
            case 'bookmark':
                $posts = $posts->sortByDesc('bookmark_count');
                break;
            case 'updated':
                $posts = $posts->sortByDesc('updated_at');
                break;
            case 'created':
            default:
                $posts = $posts->sortByDesc('created_at');
                break;
        }

        $paginated = new LengthAwarePaginator(
            $posts->forPage($page , $this->paginationCount),
            $posts->count(), $this->paginationCount, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
        return $paginated;
    }
}
