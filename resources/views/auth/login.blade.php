@extends('layouts.base')

@section('title', __('view.title.login'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.auth.login_sss')</h1>
</div>
<div class="grid-x grid-padding-x">
  <div class="medium-6 small-12 cell">
    <h4>@lang('view.auth.sss_account')</h4>
    <form role="form" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <div class="grid-x grid-padding-x">
        <div class="small-4 cell">
          <label for="name" class="text-right middle">@lang('view.auth.username')</label>
        </div>
        <div class="small-8 cell">
          <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
      </div>
      <div class="grid-x grid-padding-x">
        <div class="small-4 cell">
          <label for="password" class="text-right middle">@lang('view.auth.password')</label>
        </div>
        <div class="small-8 cell">
          <input type="password" name="password" required>
        </div>
      </div>
      <div class="grid-x">
        <div class="small-8 cell">
          <label class="text-right middle" for="remember">@lang('view.auth.remember')</label>
        </div>
        <div class="small-4 cell">
          <div class="switch large">
            <input id="remember" name="remember" type="checkbox" class="switch-input">
            <label class="switch-paddle" for="remember">
              <span class="show-for-sr">@lang('view.auth.remember')</span>
              <span class="switch-active" aria-hidden="true">Yes</span>
              <span class="switch-inactive" aria-hidden="true">No</span>
            </label>
          </div>
        </div>
      </div>
      <input type="submit" class="button expanded" value="@lang('view.auth.login')">
    </form>
    
    <a href="{{ route('password.request') }}">@lang('view.auth.forgot')</a>
  </div>
  <div class="medium-6 small-12 cell">
    <h4>@lang('view.auth.other_account')</h4>
    <p>
      @lang('view.auth.other_account_info')
    </p>
    <a class="button expanded" href="{{ route('login.twitter') }}">@lang('view.auth.login_with_twitter')</a>
    <a class="button expanded" href="{{ route('login.github') }}">@lang('view.auth.login_with_github')</a>
  </div>
</div>
@endsection