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
        'password', 'remember_token', 'twitter_id', 'github_id',
        'type'
    ];

    protected $casts = [
        'birthday' => 'date',
        'twitter_id' => 'integer',
        'github_id' => 'integer',
    ];

    //API認証でユーザー名当てる
    public function findForPassport($username)
    {
        return $this->where('name', $username)->first();
    }

    // スコープ ------------------------------------------------------------

    //APIのUser検索用
    public function scopeQueryString($query, $search)
    {
        $next = $query;
        $count = 10;
        $conds = preg_split('/\s+/', $search, 0, PREG_SPLIT_NO_EMPTY);
        foreach ($conds as $test) {
            if (strpos($test, ':') === FALSE) {
                $next = $next->where('name', 'like', '%' . $test . '%');
                continue;
            }

            $prm = explode(':', $test);
            switch ($prm[0]) {
                case 'max' :
                    $next = $next->where('id', '<=', (int)$prm[1]);
                    break;
                case 'min' :
                    $next = $next->where('id', '>=', (int)$prm[1]);
                    break;
                case 'from' :
                    $next = $next->whereDate('created_at', '<=', (int)$prm[1]);
                    break;
                case 'to' :
                    $next = $next->whereDate('created_at', '>=', (int)$prm[1]);
                    break;
                case 'count' :
                    $count = (int)$prm[1];
                    break;
                default :
                    break;
            }
        }
        return $next->take($count);
    }

    // リレーション --------------------------------------------------------

    //このユーザーが投稿したSS
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    //このユーザーが所持しているブクマ
    public function bookmarks()
    {
        return $this->hasMany('App\Bookmark');
    }
}
