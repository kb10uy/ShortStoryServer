@extends('layouts.base')

@section('title', __('view.title.login'))

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
          <input id="remember" name="remember" type="checkbox"><label for="remember">@lang('view.auth.remember')</label>
        </div>
      </div>
      
      <div class="input-group-button">
        <input type="submit" class="button expanded" value="@lang('view.auth.login')">
      </div>
    </form>
    
    <a href="{{ route('password.request') }}">@lang('view.auth.forgot')</a>
  </div>
  <div class="medium-6 small-12 columns">
    <h4>@lang('view.auth.other_account')</h4>
    <p>
      @lang('view.auth.other_account_info')
    </p>
    <a class="button expanded" href="{{ route('login.twitter') }}">@lang('view.auth.login_with_twitter')</a>
    <a class="button expanded" href="{{ route('login.github') }}">@lang('view.auth.login_with_github')</a>
  </div>
</div>
@endsection