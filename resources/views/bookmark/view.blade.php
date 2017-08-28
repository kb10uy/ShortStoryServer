@extends('layouts.base')

@section('title', $bookmark->name)

@section('content')
<div class="grid-x">
  <h1>{{ $bookmark->name }}<small>&nbsp;by&nbsp;{{ $bookmark->user->name }}</small></h1>
</div>

<div class="grid-x" id="posts-list">
  @include('post.posts-list', ['posts' => $posts])
</div>
{{ $posts->links() }}
@endsection