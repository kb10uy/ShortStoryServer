<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * User::createで複数代入できるアレ
     * (これはあれか、Railsのstrong paramsみたいなのか)
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'icon', 'description', 'birthday', 'url', 'display_name',
        'twitter_id', 'twitter_name',
        'github_id', 'github_name',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    //API認証でユーザー名当てる
    public function findForPassport($username) 
    {
        return $this->where('name', $username)->first();
    }

    //このユーザーが投稿したSS
    public function posts() 
    {
        return $this->hasMany('App\Post');
    }
}
