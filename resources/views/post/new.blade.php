@extends('layouts.base')

@section('title', '投稿する')

@section('content')
<div class="row">
  <h1>投稿する</h1>
</div>

<div class="row">
  <form role="form" method="POST" action="{{ route('post.new') }}" novalidate data-abide>
    <label>
      タイトル
      <input name="title" required type="text" placeholder="このSSのタイトルを入力">
      <span class="form-error">タイトルは必須です。</span>
    </label>
    
    <label>
      タグ
      <sss-post-tags></sss-post-tags>
      <input id="tag-text" type="text">
      <button class="button" type="button">投稿</button>
    </label>
    
    <label>
      本文
      <textarea name="text" required rows="32" placeholder="本文"></textarea>
      <span class="form-error">本文は必須です。</span>
    </label>
    
    <button class="button" type="submit">投稿</button>
  </form>
</div>
@endsection