@extends('layouts.base')

@section('title', __('view.auth.enter_new_password'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.auth.enter_new_password')</h1>
  <div class="small-12 cell">
    <form action="{{ route('password.request') }}" role="form" data-abide novalidate>
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

      <div class="input-group-button">
        <input type="submit" class="button expanded" value="@lang('view.auth.accept_password')">
      </div>
    </form>
  </div>
</div>
@endsection
