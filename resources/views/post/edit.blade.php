@extends('layouts.base')

@section('title', __('view.title.edit_post'))

@section('content')
<div class="row">
  <h1>@lang('view.title.edit_post')</h1>
</div>

<div class="row">
  <form role="form" method="POST" action="{{ route('post.edit', ['id' => $post->id]) }}" novalidate data-abide>
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PATCH">
    <label>
      タイトル
      <input name="title" required type="text" placeholder="このSSのタイトルを入力" value="{{ $post->title }}">
      <span class="form-error">タイトルは必須です。</span>
    </label>
    
    <input name="_prev_tags" id="post_hidden_tags" type="hidden" value="{{ $taglist }}">
    <label>
      タグ
      <sss-post-tags></sss-post-tags>
    </label>
    
    <label>
      本文
      <textarea name="text" required rows="32" placeholder="本文">{{ $post->text }}</textarea>
      <span class="form-error">本文は必須です。</span>
    </label>
    
    <button class="button" type="submit">投稿</button>
  </form>
</div>
@endsection