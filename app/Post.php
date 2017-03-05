<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Text;
use Redis;

class Post extends Model
{
    protected $fillable = [
        'title', 'text',
    ];

    // スコープ ------------------------------
    public function scopeVisible($query)
    {
        $result = $query->where('invisible', 0);
        if (Auth::check())
        {
            $result = $result->orWhere('user_id', Auth::user()->id);
        }
        return $result;
    }

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

    //Redis保管のデータを引っ張ってくる
    public function info()
    {
        return [
            'view_count' => Redis::zscore(config('database.keys.post-views'), $this->id),
            'nice_count' => Redis::zscore(config('database.keys.post-nices'), $this->id),
            'bad_count' => Redis::zscore(config('database.keys.post-bads'), $this->id),
        ];
    }

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
