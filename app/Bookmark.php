<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id',
    ];

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
