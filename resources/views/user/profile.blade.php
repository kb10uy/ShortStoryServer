@extends('layouts.base')

@section('title', __('view.title.profile'))

@section('content')
<div class="row">
  <h1>@lang('view.title.profile')</h1>
</div>

<div class="row" data-equalizer data-equalize-on="medium">
  <div class="medium-4 large-3 columns">
    <div class="callout small-6 medium-12 columns" data-equalizer-watch>
      <img alt="User Image" src="{{ Storage::url($user->icon) }}">
    </div>
    <div class="small-6 medium-12 columns" data-equalizer-watch>
      <h3>
        {{ $user->display_name }}
        <small>({{ $user->name }})</small>
      </h3>
      <ul>
        <li>Birthday : {{ $user->birthday }}</li>
        @if(isset($user->url))
          <li>Website : <a href="{{ $user->url }}">{{ $user->url }}</a></li>
        @endif
        @if(isset($user->twitter_name))
          <li>Twitter : <a href="https://twitter.com/{{ $user->twitter_name }}">{{ '@' . $user->twitter_name }}</a></li>
        @endif
        @if(isset($user->github_name))
          <li>GitHub : <a href="https://github.com/{{ $user->github_name }}">{{ $user->github_name }}</a></li>
        @endif
      </ul>
    </div>
  </div>
  <div class="medium-8 large-9 columns">
    <div class="small-12 columns" data-equalizer-watch>
      <ul class="tabs" data-tabs id="tabs-main">
        <li class="tabs-title is-active"><a href="#panel-notif" aria-selected="true">@lang('view.user.description')</a></li>
        <li class="tabs-title"><a href="#panel-post">投稿</a></li>
        <li class="tabs-title"><a href="#panel-misc">その他</a></li>
      </ul>
      <div class="tabs-content" data-tabs-content="tabs-main">
        <div class="tabs-panel is-active" id="panel-notif">
          <p>{{ $user->description ?: __('view.user.no-description') }}</p>
        </div>
        <div class="tabs-panel" id="panel-post">
          <p>Suspendisse dictum feugiat nisl ut dapibus.  Vivamus hendrerit arcu sed erat molestie vehicula. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor.  Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor.</p>
        </div>
        <div class="tabs-panel" id="panel-misc">
          <p>Suspendisse dictum feugiat nisl ut dapibus.  Vivamus hendrerit arcu sed erat molestie vehicula. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor.  Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection