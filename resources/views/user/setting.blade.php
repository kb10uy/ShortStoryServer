@extends('layouts.base')

@section('title', '設定')

@section('content')
<div class="row">
  <h1>設定</h1>
</div>

<div class="row collapse">
  <div class="medium-3 columns">
    <ul class="tabs vertical" id="tabs-setting" data-tabs>
      <li class="tabs-title is-active"><a href="#panel-basic" aria-selected="true">基本設定</a></li>
      <li class="tabs-title"><a href="#panel-icon">アイコン</a></li>
    </ul>
    </div>
    <div class="medium-9 columns">
    <div class="tabs-content vertical" data-tabs-content="tabs-setting">
      <div class="tabs-panel is-active" id="panel-basic">
        <!-- 基本情報 1 -->
        <h3>基本情報</h3>
        <form role="form" method="PATCH" action="{{ "#" }}" data-abide novalidate>
          {{ csrf_field() }}
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
            </div>
            <div class="small-9 columns">
              <input type="text" name="name" placeholder="使用したいユーザー名" required>
              <span class="form-error">ユーザー名は入力してください。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
            </div>
            <div class="small-9 columns">
              <input type="text" name="email" placeholder="メールアドレス" required>
              <span class="form-error">メールアドレスは入力してください。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.user.description')</label>
            </div>
            <div class="small-9 columns">
              <textarea name="description" placeholder="自己紹介的な文章を入力してください。(200文字以内)"></textarea>
              <span class="form-error">メールアドレスは入力してください。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-9 small-offset-3 columns">
              <button class="button" type="submit" value="Submit">更新</button>
            </div>
          </div>
        </form>
        
        <!-- 基本情報 1 -->
        <h3>パスワードの更新</h3>
        <form role="form" method="PATCH" action="{{ "#" }}" data-abide novalidate>
          {{ csrf_field() }}
          
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.user.cur_password')</label>
            </div>
            <div class="small-9 columns">
              <input id="password" type="password" name="password" required>
              <span class="form-error">今のパスワードを入力してください。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.user.new_password')</label>
            </div>
            <div class="small-9 columns">
              <input id="password_new" type="password" name="password" required>
              <span class="form-error">新しいパスワードを入力してください。</span>
            </div>
          </div>
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.user.new_password_confirm')</label>
            </div>
            <div class="small-9 columns">
              <input type="password" name="password_confirmation" required data-equalto="password_new">
              <span class="form-error">パスワードが一致していません。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-9 small-offset-3 columns">
              <button class="button" type="submit" value="Submit">更新</button>
            </div>
          </div>
        </form>
      </div>
      
      <!-- アイコン -->
      <div class="tabs-panel" id="panel-icon">
        
      </div>
    </div>
  </div>
</div>
@endsection