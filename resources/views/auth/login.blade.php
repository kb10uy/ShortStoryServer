@extends('layouts.base')

@section('title', 'ログイン')

@section('content')
<div class="row">
  <h1>@lang('view.auth.login_sss')</h1>
</div>
<div class="row">
  <div class="medium-6 small-12 columns">
    <h4>@lang('view.auth.sss_account')</h4>
    <form role="form" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="small-4 columns">
          <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
        </div>
        <div class="small-8 columns">
          <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
      </div>
      <div class="row">
        <div class="small-4 columns">
          <label for="right-label" class="text-right middle">@lang('view.auth.password')</label>
        </div>
        <div class="small-8 columns">
          <input type="password" name="password" required>
        </div>
      </div>
      <div class="row">
        <div class="small-4 columns"></div>
        <div class="small-8 columns">
          <input id="remember" name="remember" type="checkbox"><label for="remember">ログインしたままにする</label>
        </div>
      </div>
      
      <div class="input-group-button">
        <input type="submit" class="button expanded" value="@lang('view.auth.login')">
      </div>
    </form>
    
    <a href="{{ route('password.request') }}">パスワードを忘れた方はこちら</a>
  </div>
  <div class="medium-6 small-12 columns">
    <h4>@lang('view.auth.other_account')</h4>
    <p>
      ShortStoryServerにTwitterアカウントなどを利用してログインできます。
      一度ログインすればSSSアカウントと外部アカウント両方でログインできます。
    </p>
    <a class="button expanded" href="{{ route('login.github') }}">GitHubアカウントでログイン</a>
    <a class="button expanded" href="{{ route('login.twitter') }}">Twitterアカウントでログイン</a>
  </div>
</div>
@endsection