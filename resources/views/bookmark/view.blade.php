@extends('layouts.base')

@section('title', $bookmark->name)

@section('content')
<div class="grid-x">
  <h1>{{ $bookmark->name }} <small>{{ $bookmark->user->name }}</small></h1>
</div>

@include('post.posts-list')
@endsection