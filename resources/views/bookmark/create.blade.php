@extends('layouts.base')

@section('title', __('view.title.bookmark_create'))

@section('content')
<div class="grid-x grid-padding-x">
  <h1>@lang('view.title.bookmark_create')</h1>
</div>
<form action="{{ route('bookmark.create') }}" method="post" data-abide novalidate>
  {{ csrf_field() }}
  <div class="grid-x grid-padding-x">
    <div class="small-2 cell">
      <label for="name" class="text-right middle">タイトル</label>
    </div>
    <div class="small-10 cell">
      <input type="text" name="name" required>
      <span class="form-error">
        タイトルは必須です！
      </span>
    </div>
  </div>

  <div class="grid-x grid-padding-x">
    <div class="small-2 cell">
      <label for="description" class="text-right middle">説明</label>
    </div>
    <div class="small-10 cell">
      <input type="text" name="description">
    </div>
  </div>

  <div class="grid-x grid-padding-x">
    <div class="small-2 cell">
      <label for="description" class="text-right middle">非公開にする</label>
    </div>
    <div class="small-10 cell">
      <input class="switch-input" id="chk_protected" type="checkbox" name="protected">
      <label class="switch-paddle" for="chk_protected">
        <span class="show-for-sr">非公開にする</span>
      </label>
    </div>
  </div>

  <button type="submit" class="expanded button">作成</button>
</form>

@endsection