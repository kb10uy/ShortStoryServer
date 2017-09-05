<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookmarkEntry extends Model
{
    protected $fillable = [
        'bookmark_id', 'post_id', 'order', 'comment',
    ];

    protected $hidden = [
        'bookmark_id',
    ];

    protected $casts = [
        'order' => 'integer',
        'bookmark_id' => 'integer',
        'post_id' => 'integer,'
    ];

    // スコープ
    // postsからの継承
    public function scopeVisible($query)
    {
        return $query
            ->join('posts', 'bookmark_entries.post_id', '=', 'posts.id')
            ->select('bookmark_entries.*', 'posts.invisible')
            ->where('posts.invisible', '0');
    }


    // リレーション -----------------------------
    // 属するブックマークを取得
    public function bookmark()
    {
        return $this->belongsTo('App\Bookmark');
    }

    // 属する投稿を取得
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
