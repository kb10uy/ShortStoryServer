<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
use Image;
use Storage;

class UserSettingController extends Controller
{
    //ユーザー設定更新
    //RegisterControllerと同じ条件にする
    
    //基本情報(name, email, description)
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
            return redirect()->route('user.setting')->withErrors($validator);
        }
        
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ])->save();
        
        $request->session()->flash('updated', 'Basic information has been successfully updated!');
        return redirect()->route('user.setting');
    }
    
    //パスワード(password)
    public function updatePassword(Request $request)
    {
        //新パスワードのチェックと現パスワードの一致は別でやる
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'password_new' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            //パス形式不一致
            return redirect()->route('user.setting')->withErrors($validator);
        } elseif (!Hash::check($request->password, $user->password)) {
            //現パス不一致
            $request->errors()->add('password', 'Current password does not match!');
            return redirect()->route('user.setting')->withErrors($validator);
        } else {
            $user->fill([
                'password' => Hash::make($request->password_new)
            ])->save();
            
            $request->session()->flash('updated', 'Your password has been successfully updated!');
            return redirect()->route('user.setting');
        }
    }
    
    //アイコン(icon)
    public function updateIcon(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'file_icon' => [
                'required',
                'file',
                'image',
                Rule::dimensions()->maxWidth(1024)->maxHeight(1024),
                'max:512',
            ],
        ]);
        if ($validator->fails()) return redirect()->route('user.setting')->withErrors($validator);
        
        $file = $request->file('file_icon');
        $image = Image::make($file->path());
        $image->resize(320, null, function ($constraint) {
            $constraint->aspectRatio();
        })->crop(320, 320);
        
        //https://laracasts.com/discuss/channels/laravel/image-intervention-with-laravel-53
        $path = $file->hashName('public/avatars');
        Storage::put($path, (string)$image->encode('jpg'));
        $user->icon = $path;
        $user->save();
        
        $request->session()->flash('updated', 'Your icon has been successfully uploaded!');
        return redirect()->route('user.setting');
    }
    
    //その他情報(birthday, url, display_name)
    public function updateMisc(Request $request) 
    {
        $user = $request->user();
        $this->validate($request, [
            'birthday' => 'date',
            'url' => 'nullable|url',
        ]);
        
        $user->fill([
            'birthday' => $request->birthday,
            'url' => $request->url,
        ])->save();
        
        $request->session()->flash('updated', 'Your information has been successfully uploaded!');
        return redirect()->route('user.setting');
    }
}
