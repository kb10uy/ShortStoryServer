@extends('layouts.base')

@section('title', $post->title)

@section('content')
<div class="row" data-equalizer data-equalize-on="medium" id="postinfo">
  <div class="small-12 medium-6 large-8 columns" data-equalizer-watch>
    <h1>{{ $post->title }}</h1>
    <div>
      @include('post.post-info')
    </div>
    @include('post.post-tags')
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
    
    <nice-button tlnice="{{ __('view.post.nice') }}" tlnice_ok="{{ __('view.post.nice_ok') }}" :id="{{ $post->id }}"></nice-button>
    
  </div>
</div>
<hr>
<div class="row">
  <div class="small-12 columns">
    {!! $parsed !!}
  </div>
</div>
@endsection