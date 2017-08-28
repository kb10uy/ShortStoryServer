@extends('layouts.base')

@section('title', $user->name . 'さんのブックマーク一覧')

@section('content')
<div class="grid-x">
  <h1>{{ $user->name }}さんのブックマーク一覧</h1>
</div>

<div class="grid-x" id="posts-list">
  @include('bookmark.bookmarks-list', ['bookmarks' => $bookmarks])
</div>
{{ $bookmarks->links() }}
@endsection