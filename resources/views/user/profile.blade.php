@extends('layouts.base')

@section('title', __('view.title.profile'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.title.profile')</h1>
</div>

<div class="grid-x grid-padding-x" data-equalizer data-equalize-on="medium">
  <div class="medium-4 large-3 cell">
    <div class="callout small-6 medium-12 cell" data-equalizer-watch>
      <img alt="User Image" src="{{ Storage::url($user->icon) }}">
    </div>
    <div class="small-6 medium-12 cell" data-equalizer-watch>
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
  <div class="medium-8 large-9 cell">
    <div class="small-12 cell" data-equalizer-watch>
      <ul class="tabs" data-tabs id="tabs-main">
        <li class="tabs-title is-active"><a href="#panel-notif" aria-selected="true">@lang('view.user.description')</a></li>
        <li class="tabs-title"><a href="#panel-post">@lang('view.user.posts')</a></li>
        <li class="tabs-title"><a href="#panel-bookmark">@lang('view.user.bookmarks')</a></li>
        <li class="tabs-title"><a href="#panel-misc">その他</a></li>
      </ul>
      <div class="tabs-content" data-tabs-content="tabs-main">
        <div class="tabs-panel is-active" id="panel-notif">
          <p>{{ $user->description ?: __('view.user.no-description') }}</p>
        </div>
        <div class="tabs-panel" id="panel-post">
          <div class="grid-x">
            @foreach($posts as $post)
              <div class="small-12 cell">
                <div class="card">
                  <div class="card-divider">
                    <h3><a href="{{ route('post.view', ['id' => $post->id]) }}">{{ $post->title }}</a>&nbsp;<small>by {{ $post->user->display_name }}</small></h3>
                  </div>
                  <div class="card-section">
                    @include('post.post-info')
                    @include('post.post-tags')
                  </div>
                  <div class="card-section">
                    <p>
                      {{ $post->digest() }}
                    </p>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="small-12 cell">
              <a href="{{ route('post.search', ['q' => $user->name, 'type' => 'author', 'sort' => 'updated']) }}">@lang('view.user.posts-more')</a>
            </div>
          </div>
        </div>
        <div class="tabs-panel" id="panel-bookmark">
          <div class="grid-x">
            @foreach($posts as $post)
              <div class="small-12 cell">
                <div class="card">
                  <div class="card-divider">
                    <h3><a href="{{ route('post.view', ['id' => $post->id]) }}">{{ $post->title }}</a>&nbsp;<small>by {{ $post->user->display_name }}</small></h3>
                  </div>
                  <div class="card-section">
                    @include('post.post-info')
                    @include('post.post-tags')
                  </div>
                  <div class="card-section">
                    <p>
                      {{ $post->digest() }}
                    </p>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="small-12 cell">
              <a href="#">@lang('view.user.posts-more')</a>
            </div>
          </div>
        </div>
        <div class="tabs-panel" id="panel-misc">
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection