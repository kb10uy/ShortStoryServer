@extends('layouts.base')

@section('title', '検索する')

@section('content')
  <div class="row">
    <div class="small-12 columns">
      <h1>検索する</h1>
    </div>
    <div class="small-12 columns">
      <small>現在、実装上の都合でキーワード検索でソート順を指定することはできません。</small>
      <form role="form" action="{{ route('post.search') }}" method="GET">
        <div class="small-12 medium-8 large-6 columns">
          <input type="text" name="q" placeholder="検索キーワード">
        </div>
        <div class="small-6 medium-4 large-3 columns">
          <select name="type" id="search-type">
            <option value="keyword" selected>キーワードで</option>
            <option value="tag">タグで</option>
            <option value="author">作者で</option>
          </select>
        </div>
        <div class="small-6 medium-6 large-3 columns">
          <select name="sort" id="search-sort" disabled>
            <option value="updated">更新が新しい順</option>
            <option value="view">閲覧数が多い順</option>
            <option value="nice">これすきが多い順</option>
            <option value="bookmark">ブクマ数が多い順</option>
            <option value="" selected>(指定なし)</option>
          </select>
        </div>
        <div class="small-12 medium-6 large-12 columns">
          <button class="button primary expanded" type="submit">検索</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <h3></h3>
  </div>
@endsection