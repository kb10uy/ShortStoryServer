@extends('layouts.base')

@section('title', __('view.title.register_user'))

@section('content')
<div class="row">
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
<div class="row">
  <form role="form" method="POST" action="{{ route('register') }}" data-abide novalidate>
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
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
      </div>
      <div class="small-8 columns">
        <input type="text" name="name" placeholder="@lang('view.auth.username_p')" required>
        <span class="form-error">@lang('view.message.username_required')</span>
      </div>
    </div>
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
      </div>
      <div class="small-8 columns">
        <input type="text" name="email" placeholder="@lang('view.auth.email')" required>
        <span class="form-error">@lang('view.message.email_required')</span>
      </div>
    </div>
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.password')</label>
      </div>
      <div class="small-8 columns">
        <input id="password" type="password" name="password" required>
        <span class="form-error">@lang('view.message.password_required')</span>
      </div>
    </div>
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.password_confirm')</label>
      </div>
      <div class="small-8 columns">
        <input type="password" name="password_confirmation" required data-equalto="password">
        <span class="form-error">@lang('view.message.password_nomatch')</span>
      </div>
    </div>
    <div class="input-group-button">
      <input type="submit" class="button expanded" value="@lang('view.auth.register')">
    </div>
  </form>
</div>
@endsection
