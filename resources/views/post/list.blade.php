@extends('layouts.base')

@section('title', __('view.title.posts_list_p', ['page' => $posts->currentPage()]))

@section('content')
  <div class="grid-x">
    <h1>@lang('view.title.posts_list_p', ['page' => $posts->currentPage()])</h1>
  </div>
  <div class="grid-x" id="posts-list">
    @include('post.posts-list', ['posts' => $posts])
  </div>
  {{ $posts->links() }}
@endsection