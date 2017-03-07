<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Auth;
use Text;
use Redis;
use Session;

class Post extends Model
{
    use Searchable;

    protected $fillable = [
        'title', 'text', 'type',
        'view_count', 'nice_count', 'bad_count',
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

    //Redis --> SQLite
    public function syncInfo()
    {
        $info = $this->info();
        $this->fill([
            'view_count' => $info['view_count'] ?: 0,
            'nice_count' => $info['nice_count'] ?: 0,
            'bad_count' => $info['bad_count'] ?: 0,
        ])->save();
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
