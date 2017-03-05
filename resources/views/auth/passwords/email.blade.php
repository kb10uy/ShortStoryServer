@extends('layouts.base')
@section('title', __('view.auth.reset_password'))

@section('content')
  <div class="row">
    <h1>@lang('view.auth.reset_password')</h1>
    @if(session('status'))
      <div class="success callout">
        {{ session('status') }}
      </div>
    @endif
    <div class="small-12 columns">
      <form role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="row">
          <div class="small-4 columns">
            <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
          </div>
          <div class="small-8 columns">
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