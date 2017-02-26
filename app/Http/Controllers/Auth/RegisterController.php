<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //UserControllerと同じ条件
            'name' => 'required|max:64|alpha_dash|allowed|unique:users',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            
            'icon' => '/public/images/default.png',
        ]);
        $session = Request::session();
        
        //ソーシャルユーザー登録
        if ($session->has('twitter_id')) {
            $user->fill([
                'twitter_id' => $session->pull('twitter_id'),
                'twitter_name' => $session->pull('twitter_name'),
            ])->save();
        }
        if ($session->has('github_id')) {
            $user->fill([
                'github_id' => $session->pull('github_id'),
                'github_name' => $session->pull('github_name'),
            ])->save();
        }
        
        return $user;
    }
}
