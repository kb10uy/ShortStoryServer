@extends('layouts.base')

@section('title', $post->title)

@section('content')
<div class="row" data-equalizer data-equalize-on="medium" id="postinfo">
  <div class="small-12 medium-6 large-8 columns" data-equalizer-watch>
    <h1>{{ $post->title }}</h1>
    <div>
      @foreach($post->tags as $tag)
        <span class="primary label">{{ $tag->name }}</span>&nbsp;
      @endforeach
    </div>
  </div>
  <div class="small-12 medium-6 large-4 columns callout" data-equalizer-watch>
    <div class="media-object-section">
      <img src="{{ Storage::url($post->user->icon) }}" alt="{{ $post->user->name }}" width="80">
    </div>
    <div class="media-object-section">
      <h4>{{ $post->user->display_name }} <small>({{ $post->user->name }})</small></h4>
    </div>
  </div>
</div>
<div class="row">
  <div class="small-12 columns with-emoji">
    {!! $parsed !!}
  </div>
</div>
@endsection