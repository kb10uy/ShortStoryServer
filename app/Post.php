<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
