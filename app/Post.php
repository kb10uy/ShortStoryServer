<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Text;
use Redis;

use Mail;

use App\Mail\PostDopyulicated;

class Post extends Model
{
    public $asYouType = true;
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = [
        'created_at',
        'updated_at',
        'modofied_at',
    ];
    protected $fillable = [
        'title', 'text', 'type',
        'view_count', 'nice_count', 'bad_count',
        'modified_at',
    ];

    protected $hidden = [
        'user_id', 'type', 'pivot',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'nice_count' => 'integer',
        'bad_count' => 'integer',
    ];

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

    public function scopeSearchFulltext($query, $search)
    {
        return $query
            ->whereRaw('text &@~ :q1', ['q1' => $search])
            ->orWhereRaw('title &@~ :q2', ['q2' => $search]);
    }

    // 検証 ------------------------------------------------------

    static public function updatable(Post $post = null, &$response)
    {
        if (!$post) {
            session()->flash('alert', __('view.message.post_not_exist'));
            $response = redirect()->route('home');
            return false;
        } elseif (Auth::user()->cant('update', $post)) {
            session()->flash('alert', __('view.message.post_cant_edit'));
            $response = redirect()->route('home');
            return false;
        }
        return true;
    }

    static public function visibleForMe(Post $post = null, &$response)
    {
        if (!$post) {
            session()->flash('alert', __('view.message.post_not_exist'));
            $response = redirect()->route('home');
            return false;
        } elseif ($post->invisible && Auth::user() != $post->user) {
            session()->flash('warning', __('view.message.post_invisible'));
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
            'view_count' => (int)Redis::zscore(config('database.keys.post-views'), $this->id),
            'nice_count' => (int)Redis::zscore(config('database.keys.post-nices'), $this->id),
            'bad_count' => (int)Redis::zscore(config('database.keys.post-bads'), $this->id),
        ];
    }

    //Redis --> $this
    //あくまで検索用、表示に使うときはinfo()使ってね
    public function applyCachedInfo()
    {
        $info = $this->info();
        $this->view_count = $info['view_count'] ?: 0;
        $this->nice_count = $info['nice_count'] ?: 0;
        $this->bad_count = $info['bad_count'] ?: 0;
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
    // 投稿したユーザーを取得
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // この投稿のタグを取得
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    // この投稿が登録されてるブクマを取得
    // Deprecated: 互換性のために存在
    public function bookmarks()
    {
        return $this->belongsToMany('App\Bookmark')->withTimestamps();
    }

    // この投稿に紐付いてるブックマークエントリを取得
    public function bookmarkEntries()
    {
        return $this->hasMany('App\BookmarkEntry');
    }
}
