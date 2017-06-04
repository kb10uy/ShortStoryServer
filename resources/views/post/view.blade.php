@extends('layouts.base')

@section('title', $post->title)

@section('content')
@if(Agent::isMobile())
  <div class="row">
    <h1>{{ $post->title }}</h1>
  </div>
@else
  <div class="row" id="postinfo">
    <div class="small-12 medium-6 large-8 columns">
      <h1>{{ $post->title }}</h1>
      <p>
        @include('post.post-info')
        @include('post.post-tags')
      </p>
    </div>
    <div class="small-12 medium-6 large-4 columns">
      <div class="card">
        <div class="card-section">
          <div class="media-object-section">
            <img src="{{ Storage::url($post->user->icon) }}" alt="{{ $post->user->name }}" width="80">
          </div>
          <div class="media-object-section">
            <h4><a href="{{ route('user.profile', ['id' => $post->user->name]) }}">{{ $post->user->display_name }}</a> <small>({{ $post->user->name }})</small></h4>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

<hr>

<div class="row">
  @if(Agent::isMobile())
    <div class="small-12 columns with-emoji" id="text-body">
      {!! $parsed['text'] !!}
    </div>
  @else
    <div class="medium-8 columns with-emoji" id="text-body">
      {!! $parsed['text'] !!}
    </div>
    <div class="medium-4 columns" data-sticky-container>
      <div class="sticky callout" data-sticky data-anchor="text-body">
        @if(Auth::check())
          <nice-button tlnice="{{ __('view.post.nice') }}" tlnice_ok="{{ __('view.post.nice_ok') }}"
                        :id="{{ $post->id }}" :nice_count="{{ $post->info()['nice_count'] }}">
          </nice-button>
          <dopyulicate-button tldopyu="シコりメールを送る" tldopyu_ok="送信されました！" :id="{{ $post->id }}"></dopyulicate-button>
          
          @if(Auth::user() == $post->user)
            <ul class="vertical menu" data-accordion-menu>
              <li>
                <a href="#">作者メニュー</a>
                <ul class="vertical menu nested">
                  <li><a href="{{ route('post.edit', ['id' => $post->id]) }}">編集する</a></li>
                  <li><a href="#" data-toggle="delete-modal">@lang('view.post.delete')</a></li>
                  <li><a href="#">非公開にする</a></li>
                </ul>
              </li>
            </ul>
          @endif
        @else
          <a class="button primary expanded" href="{{ route('login') }}">ログインして評価する</a>
        @endif
        @if(count($parsed['anchors']) > 0)
          <hr class="raw">
          <ul class="vertical menu">
            @foreach($parsed['anchors'] as $anchor)
              <li><a href="#{{ $anchor[1] }}">{{ $anchor[0] }}</a></li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  @endif
</div>

@component('layouts.modal-confirm')
  @slot('title', __('view.post.delete'))
  @slot('message', '一度削除した作品は復元することはできません。本当に削除してもよろしいですか？')
  @slot('confirm', __('view.post.delete'))
  @slot('id', 'delete-modal')
  @slot('method', 'delete')
  @slot('action', route('post.delete', ['id' => $post->id]))
@endcomponent
@endsection

@section('mobile-offcanvas')
<ul class="vertical menu" data-accordion-menu>
  <li>
    <a href="#">作者情報</a>
    <ul class="nested vertical menu">
      <li>{{ $post->user->display_name }}</li>
      <li><a href="{{ route('user.profile', ['id' => $post->user->name]) }}">プロフィール</a></li>
    </ul>
  </li>
  <li>
    <a href="#">タグ</a>
    <ul class="nested vertical menu">
      @foreach($post->tags as $tag)
        <li><a href="{{ route('post.search', ['q' => $tag->name, 'type'=> 'tag', 'sort' => 'updated']) }}">{{ $tag->name }}</a></li>
      @endforeach
    </ul>
  </li>
</ul>
<ul>
  <li><i class="fi-eye"></i> 閲覧: {{ ($postinfo ?? $post->info())['view_count'] ?? 0 }}</li>
  <li><i class="fi-like"></i> いいね: {{ ($postinfo ?? $post->info())['nice_count'] ?? 0}}</li>
  <li><i class="fi-bookmark"></i> ブクマ: 0</li>
  <li><i class="fi-comment"></i> コメ: 0</li>
</ul>

<hr class="raw">

@if(Auth::check())
  <nice-button tlnice="{{ __('view.post.nice') }}" tlnice_ok="{{ __('view.post.nice_ok') }}"
                :id="{{ $post->id }}" :nice_count="{{ $post->info()['nice_count'] }}">
  </nice-button>
  <dopyulicate-button tldopyu="シコりメールを送る" tldopyu_ok="送信されました！" :id="{{ $post->id }}"></dopyulicate-button>
@else
  <a class="button primary expanded" href="{{ route('login') }}">ログインして評価する</a>
@endif

@if(Auth::user() == $post->user)
  <hr class="raw">
  <ul class="vertical menu" data-accordion-menu>
    <li>
      <a href="#">作者メニュー</a>
      <ul class="vertical menu nested">
        <li><a href="{{ route('post.edit', ['id' => $post->id]) }}">編集する</a></li>
        <li><a href="#" data-toggle="delete-modal">@lang('view.post.delete')</a></li>
        <li><a href="#">非公開にする</a></li>
      </ul>
    </li>
  </ul>
@endif

@if(count($parsed['anchors']) > 0)
  <hr class="raw">
  <ul class="vertical menu">
    @foreach($parsed['anchors'] as $anchor)
      <li><a href="#{{ $anchor[1] }}">{{ $anchor[0] }}</a></li>
    @endforeach
  </ul>
@endif

@endsection