@extends('layouts.base')
@section('title', __('view.auth.reset_password'))

@section('content')
  <div class="grid-x">
    @if(session('status'))
      <div class="success callout">
        {{ session('status') }}
      </div>
    @endif
    <h1>@lang('view.auth.reset_password')</h1>
    <div class="small-12 cell">
      <form role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="grid-x grid-padding-x">
          <div class="small-4 cell">
            <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
          </div>
          <div class="small-8 cell">
            <input type="email" name="email" value="{{ old('email') }}" required>
          </div>
        </div>

        <div class="input-group-button">
          <input type="submit" class="button expanded" value="{{ __('view.auth.send_reset_link') }}">
        </div>
      </form>
    </div>
  </div>
@endsection