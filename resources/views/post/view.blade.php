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
  <div class="medium-8 columns" id="text-body">
    {!! $parsed !!}
  </div>
  <div class="medium-4 columns" data-sticky-container>
    <div class="sticky callout" data-sticky data-anchor="text-body">
      @if(Auth::check())
        
        <nice-button tlnice="{{ __('view.post.nice') }}" tlnice_ok="{{ __('view.post.nice_ok') }}"
                     :id="{{ $post->id }}" :nice_count="{{ ($postinfo ?? $post->info())['nice_count'] }}">
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
    </div>
  </div>
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