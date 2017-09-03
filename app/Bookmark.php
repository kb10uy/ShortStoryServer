<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Bookmark extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id', 'invisible',
    ];

    protected $hidden = [
        'user_id', 'pivot',
    ];

    // 多分めんどくさくなる投稿の登録をする
    public function registerPost(Post $post)
    {
        if ($this->entries()->where('post_id', $post->id)->first()) {
            return false;
        }

        $count = $this->entries()->count();
        $entry = BookmarkEntry::create([
            'bookmark_id' => $this->id,
            'post_id' => $post->id,
            'order' => $count,
        ]);
        return $entry;
    }

    // Postインスタンスからブクマエントリを削除
    public function removePostByInstance(Post $post)
    {
        $entry = $this->entries()->where('post_id', $post->id)->delete();
    }

    // PostのIDからエントリを削除
    public function removePostById($id)
    {
        $entry = $this->entries()->where('post_id', $id)->delete();
    }

    // エントリのorder位置から削除。
    // orderではなく並べた順なので正規化してない状態でも使用可能。
    public function removeAt($index)
    {
        $entry = $this->entries()->orderBy('order')->skip($index)->first()->delete();
    }

    // ♪雨上がりには～虹がかかるよ～
    public function upgradeRelation()
    {
        foreach ($this->posts as $post) {
            $this->registerPost($post);
            $this->posts()->detach($post);
        }
    }

    // スコープ --------------------------------------------------
    public function scopeVisible($query)
    {
        //未実装
        return $query;
    }

    public function visibleNow()
    {
        return true; // !($this->invisible && (Auth::check() ? Auth::user() != $this->user : false));
    }

    public static function visibleForMe(Bookmark $bookmark = null, &$response)
    {
        /*
        if (!$bookmark) {
            Session::flash('alert', __('view.message.bookmark_not_exist'));
            $response = redirect()->route('home');
            return false;
        } elseif ($bookmark->invisible && Auth::user() != $bookmark->user) {
            Session::flash('warning', __('view.message.bookmark_invisible'));
            $response = redirect()->route('home');
            return false;
        }
        */

        return true;
    }

    // リレーション ----------------------------------------------
    // 投稿したユーザーを取得
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // この投稿が登録されてるブクマを取得
    // Deprecated: 今のところ互換性のために存在します
    public function posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }

    // ブクマのエントリ(詳細情報)を取得
    public function entries()
    {
        return $this->hasMany('App\BookmarkEntry');
    }
}
