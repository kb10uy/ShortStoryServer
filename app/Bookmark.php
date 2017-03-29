<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class Bookmark extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id',
    ];

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

    static public function visibleForMe(Bookmark $bookmark = null, &$response) 
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
    //投稿したユーザーを取得
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //この投稿が登録されてるブクマを取得
    public function posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
