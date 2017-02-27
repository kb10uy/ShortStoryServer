@extends('layouts.base')

@section('title', __('view.title.post'))

@section('content')
<div class="row">
  <h1>@lang('view.title.post')</h1>
</div>

<div class="row">
  <form role="form" method="POST" action="{{ route('post.new') }}" novalidate data-abide>
    {{ csrf_field() }}
    <label>
      タイトル
      <input name="title" required type="text" placeholder="このSSのタイトルを入力">
      <span class="form-error">タイトルは必須です。</span>
    </label>
    
    <label>
      タグ
      <sss-post-tags></sss-post-tags>
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