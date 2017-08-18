<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['name'];

    protected $hidden = ['pivot'];

    //関連する投稿を取得します
    public function posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
