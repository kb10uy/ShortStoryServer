@extends('layouts.base')

@section('title', __('view.title.posts_list_p', ['page' => $posts->currentPage()]))

@section('content')
  <div class="row">
    <h1>@lang('view.title.posts_list_p', ['page' => $posts->currentPage()])</h1>
  </div>
  @include('post.posts-list')
@endsection