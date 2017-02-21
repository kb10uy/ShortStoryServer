@extends('layouts.base')

@section('title', '設定')

@section('content')
<div class="row">
  <h1>設定</h1>
  @if($errors->any())
    <div data-abide-error class="warning callout">
      <ul>
        @foreach($errors->all() as $message)
          <li>{{ $message }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if(Session::has('basic_updated'))
    <div data-abide-error class="success callout">
      {{ Session::get('basic_updated') }}
    </div>
  @endif
  @if(Session::has('password_updated'))
    <div data-abide-error class="success callout">
      {{ Session::get('password_updated') }}
    </div>
  @endif
  @if(Session::has('icon_uploaded'))
    <div data-abide-error class="success callout">
      {{ Session::get('icon_uploaded') }}
    </div>
  @endif
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
        <form role="form" method="POST" action="{{ route('user.update.basic') }}" data-abide novalidate>
          {{ csrf_field() }}
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
            </div>
            <div class="small-9 columns">
              <input type="text" name="name" placeholder="使用したいユーザー名" required value="{{ Auth::user()->name }}">
              <span class="form-error">ユーザー名は入力してください。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
            </div>
            <div class="small-9 columns">
              <input type="text" name="email" placeholder="メールアドレス" required value="{{ Auth::user()->email }}">
              <span class="form-error">メールアドレスは入力してください。</span>
            </div>
          </div>
          
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.user.description')</label>
            </div>
            <div class="small-9 columns">
              <textarea name="description" placeholder="自己紹介的な文章を入力してください。(200文字以内)">{{ Auth::user()->description }}</textarea>
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
        <form role="form" method="POST" action="{{ route('user.update.password') }}" data-abide novalidate>
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
              <input id="password_new" type="password" name="password_new" required>
              <span class="form-error">新しいパスワードを入力してください。</span>
            </div>
          </div>
          <div class="row">
            <div class="small-3 columns">
              <label for="right-label" class="text-right middle">@lang('view.user.new_password_confirm')</label>
            </div>
            <div class="small-9 columns">
              <input type="password" name="password_new_confirmation" required data-equalto="password_new">
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
        <div class="row" data-equalizer data-equalize-on="medium">
          <div class="small-12 columns">
            <h3>アイコン</h3>
          </div>
          
          <div class="small-6 medium-4 columns">
            <div class="callout" data-equalizer-watch>
              <img alt="Current icon" src="{{ Storage::url(Auth::user()->icon) }}">
            </div>
          </div>
          
          <div class="small-6 medium-8 columns" data-equalizer-watch>
            <ul>
              <li>対応形式: PNG, JPEG, GIF</li>
              <li>最大サイズ: 1024x1024, 512KB</li>
              <li>内部で320x320 JPEGに縮小・変換されます</li>
            </ul>
            <!-- アイコン アップロード -->
            <form role="form" method="POST" enctype="multipart/form-data" action="{{ route('user.update.icon') }}" data-abide novalidate>
              {{ csrf_field() }}
              <label for="fileupicon" class="button">ファイルを選択</label>
              <input type="file" name="file_icon" id="fileupicon" class="show-for-sr">
              <button class="button" type="submit" value="Submit">更新</button>
            </form>
          </div>
        
        </div>
      </div>
    </div>
  </div>
</div>
@endsection