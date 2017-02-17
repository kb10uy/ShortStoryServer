@extends('layouts.base')

@section('content')
<div class="row">
  <h1>@lang('view.user.login_sss')</h1>
</div>
<div class="row">
  <div class="medium-6 small-12 columns">
    <h4>@lang('view.user.sss_account')</h4>
    <form>
      {{ csrf_field() }}
      <div class="row">
        <div class="small-4 columns">
          <label for="right-label" class="text-right middle">@lang('view.user.username')</label>
        </div>
        <div class="small-8 columns">
          <input type="text" id="login-username">
        </div>
      </div>
      <div class="row">
        <div class="small-4 columns">
          <label for="right-label" class="text-right middle">@lang('view.user.password')</label>
        </div>
        <div class="small-8 columns">
          <input type="password" id="login-password">
        </div>
      </div>
      <div class="input-group-button">
        <input type="submit" class="button expanded" value="ログイン">
      </div>
    </form>
    
    <a href="#">ユーザー名・パスワードを忘れた</a>
  </div>
  <div class="medium-6 small-12 columns">
    <h4>@lang('view.user.other_account')</h4>
    <p>
      ShortStoryServerにTwitterアカウントなどを利用してログインできます。
      一度ログインすればSSSアカウントと外部アカウント両方でログインできます。
    </p>
    <a class="button expanded" href="#">GitHubアカウントでログイン</a>
    <a class="button expanded" href="#">Twitterアカウントでログイン</a>
  </div>
</div>
@endsection