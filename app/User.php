<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * User::createで複数代入できるアレ
     * (これはあれか、Railsのstrong paramsみたいなのか)
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'icon', 'description', 'birthday', 'url',
        'twitter_id', 'twitter_name',
        'github_id', 'github_name',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    //このユーザーが投稿したSS
    public function posts() 
    {
        return $this->hasMany('App\Post');
    }
}
