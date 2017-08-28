<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use App\Post;
use App\Tag;
use App\User;
use App\Jobs\SyncPostInfoToDatabase;
use App\Utilities\ViewExtra;

use Auth;
use Text;
use Redis;

class PostController extends Controller
{
    public $paginationCount = 10;
    public $request = null;

    public function __construct(Request $request) 
    {
        $this->request = $request;
    }

    // /post/{id} (GET)
    public function view($id) 
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
    public function list()
    {
        $posts = Post::with(['tags', 'user'])->visible();
        if ($this->request->has('sort')) {
            switch($this->request->input('sort')) {
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

    public function search()
    {
        if (!$this->request->has('q')) return view('post.search');
        
        // whereIn句で書き直したほうが良いかも 要検証
        switch($this->request->input('type')) {
            case 'keyword':
                $posts = $this->paginatePosts(Post::search($this->request->input('q'))->get());
                break;
            case 'tag':
                $posts = $this->paginatePosts($this->getPostsOfTags($this->request->input('q')));
                break;
            case 'author':
                $posts = $this->paginatePosts($this->getPostsOfUsers($this->request->input('q')));
                break;
            default:
                $posts = Post::visible()->with(['tags', 'user'])->paginate($this->paginationCount);
                break;
        }
        //dd($posts);
        dispatch(new SyncPostInfoToDatabase);
        return view('post.search', [
            'posts' => $posts,
            'request' => [
                'q' => $this->request->input('q'),
                'keyword' => $this->request->input('keyword'),
                'type' => $this->request->input('type'),
            ],
        ]);
    }

    public function getPostsOfTags($query)
    {
        $tags = collect(preg_split('/[\s　]/u', $query, -1, PREG_SPLIT_NO_EMPTY))
            ->map(function($item, $key) {
                return Tag::where('name', $item)->with(['posts.user'])->first();
            })
            ->filter()
            ->keyBy('id');
        if ($tags->count() == 0)  return collect([]);

        $results = collect($tags->first()->posts->keyBy('id'));
        $tags = $tags->slice(1);
        foreach($tags as $tag) {
            $posts = $tag->posts->keyBy('id')->map(function($item, $key) {
                return $item->applyCachedInfo();
            });
            $results = $results->intersect($posts->keyBy('id'));
        }
        return $results;
    }

    public function getPostsOfUsers($query)
    {
        $users = collect(preg_split('/[\s　]/u', $query, -1, PREG_SPLIT_NO_EMPTY))
            ->map(function($item, $key) {
                return User::where('name', $item)->with('posts.tags', 'posts.user')->first();
            })
            ->filter()
            ->keyBy('id');
        if ($users->count() == 0)  return collect([]);

        $results = collect([]);
        foreach($users as $user) {
            $posts = $user->posts->keyBy('id')->map(function($item, $key) {
                return $item->applyCachedInfo();
            });
            $results = $results->union($posts->keyBy('id'));
        }
        return $results;
    }

    public function paginatePosts($posts)
    {
        $sort = $this->request['sort'];
        $page = (int)$this->request['page'];
        $posts = $posts->filter(function($item, $key) {
            return $item->visibleNow();
        });
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
                //updated_atは別にとっておくことにします。
                $posts = $posts->sortByDesc('modified_at');
                break;
            case 'created':
            default:
                $posts = $posts->sortByDesc('created_at');
                break;
        }
        $paginated = new LengthAwarePaginator(
            $posts->forPage($page , $this->paginationCount),
            $posts->count(), $this->paginationCount, $page,
            ['path' => $this->request->url(), 'query' => $this->request->query()]);
        return $paginated;
    }
}
