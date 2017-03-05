<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Text;
use Redis;
use Session;

class Post extends Model
{
    protected $fillable = [
        'title', 'text',
    ];

    // スコープ & 検証 ----------------------------------------------
    public function scopeVisible($query)
    {
        $result = $query->where('invisible', 0);
        if (Auth::check())
        {
            $result = $result->orWhere('user_id', Auth::user()->id);
        }
        return $result;
    }

    // 検証
    
    static public function updatable(Post $post, &$response)
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

    static public function visibleForMe(Post $post, &$response) 
    {
        if (!$post) {
            Session::flash('alert', __('view.message.post_not_exist'));
            $response = redirect()->route('home');
            return false;
        } elseif ($post->invisible) {
            Session::flash('warning', __('view.message.post_invisible'));
            $response = redirect()->route('home');
            return false;
        }
        return true;
    }

    // DBにもたない補助データ --------------------------------
    //短縮表示用のダイジェスト本文
    public function digest()
    {
        $raw = Text::parseToPlain('s3wf', $this->text);
        if (strlen($raw) > 100) {
            return mb_substr($raw, 0, 100) . '…';
        } else {
            return $raw;
        }
    }

    //Redis保管のデータを初期化する
    public function initInfo()
    {
        Redis::zincrby(config('database.keys.post-views'), 0, $post->id);
        Redis::zincrby(config('database.keys.post-nices'), 0, $post->id);
        Redis::zincrby(config('database.keys.post-bads'), 0, $post->id);
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
}
