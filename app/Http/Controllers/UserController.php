<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        //そりゃお前ログイン済みでしょ
        $this->middleware('auth')->except('profile');
    }
    
    public function profile()
    {
        return view('user.profile');
    }
    
    public function setting()
    {
        return view('user.setting');
    }
    
    //ユーザー設定更新
    //RegisterControllerと同じ条件にする
    public function updateBasic(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:64',
                'alpha_dash',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => 'required|email|max:255',
            'description' => 'nullable|max:200',
        ]);
        if ($validator->fails()) {
            return redirect(route('user.setting'))->withErrors($validator);
        }
        
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ])->save();
        
        $request->session()->flash('basic_updated', 'Basic information has been successfully updated!');
        return redirect(route('user.setting'));
    }
    
    public function updatePassword(Request $request)
    {
        //新パスワードのチェックと現パスワードの一致は別でやる
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'password_new' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) 
        {
            //パス形式不一致
            return redirect(route('user.setting'))->withErrors($validator);
        }
        else if (!Hash::check($request->password, $user->password)) {
            //現パス不一致
            $request->session()->flash('current_password', 'Current password does not match!');
            return redirect(route('user.setting'))->withErrors($validator);
        } else {
            $user->fill([
                'password' => Hash::make($request->password_new)
            ])->save();
            
            $request->session()->flash('password_updated', 'Your password has been successfully updated!');
            return redirect(route('user.setting'));
        }
    }
    
    public function updateIcon(Request $request)
    {
        
    }
}