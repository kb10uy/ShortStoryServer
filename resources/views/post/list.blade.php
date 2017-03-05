@extends('layouts.base')

@section('title', __('view.title.posts_list_p', ['page' => $posts->currentPage()]))

@section('content')
  <div class="row">
    <h1>@lang('view.title.posts_list_p', ['page' => $posts->currentPage()])</h1>
  </div>
  <div class="row"  data-equalizer data-equalize-on="medium" id="posts-list">
    @foreach($posts as $post)
      <div class="small-12 large-6 columns">
        <div class="callout" data-equalizer-watch>
          <h3><a href="{{ route('post.view', ['id' => $post->id]) }}">{{ $post->title }}</a></h3>
          <blockquote>
            {{ $post->digest() }}
          </blockquote>
        </div>
      </div>
    @endforeach
  </div>

  {{ $posts->links() }}
@endsection