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

    public $request = null;

    public function __construct(Request $request) 
    {
        $this->request = $request;
    }

    //基本情報(name, email, description)
    public function updateBasic()
    {
        $user = $this->request->user();
        $validator = Validator::make($this->request->all(), [
            'name' => [
                'required',
                'max:64',
                'alpha_dash',
                'allowed',
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
        
        session()->flash('success', __('view.message.basic_info_updated'));
        return redirect()->route('user.setting');
    }
    
    //パスワード(password)
    public function updatePassword()
    {
        //新パスワードのチェックと現パスワードの一致は別でやる
        $user = $this->request->user();
        $validator = Validator::make($this->request->all(), [
            'password' => 'required|min:6',
            'password_new' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            //パス形式不一致
            return redirect()->route('user.setting')->withErrors($validator);
        } elseif (!Hash::check($this->request->password, $user->password)) {
            //現パス不一致
            $this->request->errors()->add('password', __('view.message.password_nomatch'));
            return redirect()->route('user.setting')->withErrors($validator);
        } else {
            $user->fill([
                'password' => Hash::make($this->request->password_new)
            ])->save();
            
            session()->flash('success', __('view.message.password_updated'));
            return redirect()->route('user.setting');
        }
    }
    
    //アイコン(icon)
    public function updateIcon()
    {
        $user = $this->request->user();
        $validator = Validator::make($this->request->all(), [
            'file_icon' => [
                'required',
                'file',
                'image',
                Rule::dimensions()->maxWidth(1024)->maxHeight(1024),
                'max:512',
            ],
        ]);
        if ($validator->fails()) return redirect()->route('user.setting')->withErrors($validator);
        
        $file = $this->request->file('file_icon');
        $image = Image::make($file->path());
        $image->resize(320, null, function ($constraint) {
            $constraint->aspectRatio();
        })->crop(320, 320);
        
        //https://laracasts.com/discuss/channels/laravel/image-intervention-with-laravel-53
        $path = $file->hashName('public/avatars');
        Storage::put($path, (string)$image->encode('jpg'));
        $user->icon = $path;
        $user->save();
        
        session()->flash('success', __('view.message.icon_updated'));
        return redirect()->route('user.setting');
    }
    
    //その他情報(birthday, url, display_name)
    public function updateMisc() 
    {
        $user = $this->request->user();
        $this->validate($this->request, [
            'birthday' => 'date',
            'url' => 'nullable|url',
            'display_name' => 'nullable|max:64',
        ]);
        
        $user->fill([
            'birthday' => $this->request->birthday,
            'url' => $this->request->url,
            'display_name' => $this->request->display_name ?: $this->request->user()->name,
        ])->save();
        
        session()->flash('success', __('view.message.misc_info_updated'));
        return redirect()->route('user.setting');
    }
}
