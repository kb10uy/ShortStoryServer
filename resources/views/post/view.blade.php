@extends('layouts.base')

@section('title', $post->title)

@section('content')
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

<hr>

<div class="row">
  <div class="small-12 columns">
    @if(Auth::check())
      <nice-button tlnice="{{ __('view.post.nice') }}" tlnice_ok="{{ __('view.post.nice_ok') }}" :id="{{ $post->id }}"></nice-button>
      <dopyulicate-button tldopyu="シコりメールを送る" tldopyu_ok="送信されました！" :id="{{ $post->id }}"></dopyulicate-button>
      @if(Auth::user() == $post->user)
        <button class="dropdown button" data-toggle="author-menu">作者メニュー</button>
        <div class="dropdown-pane bottom right" id="author-menu" data-dropdown>
          <ul class="vertical dropdown menu" data-dropdown-menu>
            <li><a href="{{ route('post.edit', ['id' => $post->id]) }}">編集</a></li>
            <!-- <li><a href="#">非公開にする</a></li> -->
            <li><a href="#" data-toggle="delete-modal">@lang('view.post.delete')</a></li>
            @component('layouts.modal-confirm')
              @slot('title', __('view.post.delete'))
              @slot('message', '一度削除した作品は復元することはできません。本当に削除してもよろしいですか？')
              @slot('confirm', __('view.post.delete'))
              @slot('id', 'delete-modal')
              @slot('method', 'delete')
              @slot('action', route('post.delete', ['id' => $post->id]))
            @endcomponent
          </ul>
        </div>
      @endif
    @else
      <a class="button primary" href="{{ route('login') }}">ログインして評価する</a>
    @endif
  </div>
</div>
<hr>
<div class="row">
  <div class="small-12 columns">
    {!! $parsed !!}
  </div>
</div>
@endsection