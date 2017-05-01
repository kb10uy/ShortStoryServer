<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Auth;
use Text;
use Redis;
use Session;
use Mail;

use App\Mail\PostDopyulicated;

class Post extends Model
{
    use Searchable;

    protected $fillable = [
        'title', 'text', 'type',
        'view_count', 'nice_count', 'bad_count',
        'modified_at',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array = array_intersect_key($array, ['title' => '', 'text' => '']);

        return $array;
    }

    // スコープ ----------------------------------------------
    public function scopeVisible($query)
    {
        $result = $query->where('invisible', 0);
        if (Auth::check())
        {
            $result = $result->orWhere('user_id', Auth::user()->id);
        }
        return $result;
    }

    // 検証 ------------------------------------------------------
    
    static public function updatable(Post $post = null, &$response)
    {
        if (!$post) {
            Session::flash('alert', __('view.message.post_not_exist'));
            $response = redirect()->route('home');
            return false;
        } elseif (Auth::user()->cant('update', $post)) {
            Session::flash('alert', __('view.message.post_cant_edit'));
            $response = redirect()->route('home');
            return false;
        }
        return true;
    }

    static public function visibleForMe(Post $post = null, &$response) 
    {
        if (!$post) {
            Session::flash('alert', __('view.message.post_not_exist'));
            $response = redirect()->route('home');
            return false;
        } elseif ($post->invisible && Auth::user() != $post->user) {
            Session::flash('warning', __('view.message.post_invisible'));
            $response = redirect()->route('home');
            return false;
        }
        return true;
    }

    public function visibleNow()
    {
        return !($this->invisible && (Auth::check() ? Auth::user() != $this->user : false));
    }

    // DBにもたない補助データ --------------------------------
    //短縮表示用のダイジェスト本文
    public function digest()
    {
        $raw = Text::parseToPlain($this->type, $this->text);
        if (strlen($raw) > 100) {
            return mb_substr($raw, 0, 100) . '…';
        } else {
            return $raw;
        }
    }

    //Redis保管のデータを初期化する
    public function initInfo()
    {
        Redis::zincrby(config('database.keys.post-views'), 0, $this->id);
        Redis::zincrby(config('database.keys.post-nices'), 0, $this->id);
        Redis::zincrby(config('database.keys.post-bads'), 0, $this->id);
    }

    //Redis保管のデータを引っ張ってくる
    public function info()
    {
        return [
            'view_count' => Redis::zscore(config('database.keys.post-views'), $this->id),
            'nice_count' => Redis::zscore(config('database.keys.post-nices'), $this->id),
            'bad_count' => Redis::zscore(config('database.keys.post-bads'), $this->id),
        ];
    }
    
    //Redis --> $this
    //あくまで検索用、表示に使うときはinfo()使ってね
    public function applyCachedInfo() 
    {
        $info = $this->info();
        $this->view_count = $info['view_count'];
        $this->nice_count = $info['nice_count'];
        $this->bad_count = $info['bad_count'];
        return $this;
    }

    //いいね
    public function performNice()
    {
        Redis::zincrby(config('database.keys.post-nices'), 1, $this->id);
    }

    //よくないね
    public function performBad()
    {
        Redis::zincrby(config('database.keys.post-bads'), 1, $this->id);
    }

    public function performDopyulicate()
    {
        //TODO: UserモデルにpermitDopyulicationMailを用意して
        //      そっち側で送信を決定したほうがいい
        Mail::to($this->user->email)->send(new PostDopyulicated($this));
    }

    // リレーション ----------------------------------------------
    //投稿したユーザーを取得
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //この投稿のタグを取得
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    //この投稿が登録されてるブクマを取得
    public function bookmarks()
    {
        return $this->belongsToMany('App\Bookmark')->withTimestamps();
    }
}
