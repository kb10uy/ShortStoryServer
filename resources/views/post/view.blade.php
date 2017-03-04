@extends('layouts.base')

@section('title', $post->title)

@section('content')
<div class="row">
  <div class="small-12 columns">
    <h1>{{ $post->title }}</h1>
  </div>
</div>
<div class="row">
  <div class="small-12 columns">
    <p>
      {{ $post->text }}
    </p>
  </div>
</div>
@endsection