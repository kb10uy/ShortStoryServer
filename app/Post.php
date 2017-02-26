<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //投稿したユーザーを取得
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
