@extends('layouts.base')

@section('title', __('view.title.register_user'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.auth.register_account')</h1>
  <p>
    @lang('view.auth.register_intro')
  </p>
  @if(Session::has('information'))
    <div data-abide-error class="primary callout">
      {{ Session::get('information') }}
    </div>
  @endif
</div>
<div class="grid-x">
  <form role="form" method="POST" action="{{ route('register') }}" class="cell" data-abide novalidate>
    <!-- エラー表示 -->
    @if ($errors->has('name'))
      <div data-abide-error class="warning callout">
        {{ $errors->first('name') }}
      </div>
    @endif
    @if ($errors->has('email'))
      <div data-abide-error class="warning callout">
        {{ $errors->first('email') }}
      </div>
    @endif
    
    {{ csrf_field() }}
    <div class="grid-x grid-padding-x">
      <div class="small-4 cell">
        <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
      </div>
      <div class="small-8 cell">
        <input type="text" name="name" placeholder="@lang('view.auth.username_p')" required>
        <span class="form-error">@lang('view.message.username_required')</span>
      </div>
    </div>
    <div class="grid-x grid-padding-x">
      <div class="small-4 cell">
        <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
      </div>
      <div class="small-8 cell">
        <input type="text" name="email" placeholder="@lang('view.auth.email')" required>
        <span class="form-error">@lang('view.message.email_required')</span>
      </div>
    </div>
    <div class="grid-x grid-padding-x">
      <div class="small-4 cell">
        <label for="right-label" class="text-right middle">@lang('view.auth.password')</label>
      </div>
      <div class="small-8 cell">
        <input id="password" type="password" name="password" required>
        <span class="form-error">@lang('view.message.password_required')</span>
      </div>
    </div>
    <div class="grid-x grid-padding-x">
      <div class="small-4 cell">
        <label for="right-label" class="text-right middle">@lang('view.auth.password_confirm')</label>
      </div>
      <div class="small-8 cell">
        <input type="password" name="password_confirmation" required data-equalto="password">
        <span class="form-error">@lang('view.message.password_nomatch')</span>
      </div>
    </div>
    <input type="submit" class="button expanded" value="@lang('view.auth.register')">
  </form>
</div>
@endsection
