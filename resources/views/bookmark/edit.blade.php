@extends('layouts.base')

@section('title', 'ブックマークを編集')

@section('content')
<div class="grid-x">
  <h1>ブックマークを編集する</h1>
</div>

<bookmark-editor :bookmark-id="{{ $id }}"></bookmark-editor>

@endsection
