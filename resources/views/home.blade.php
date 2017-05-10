@extends('layouts.base')

@section('title', __('view.title.home'))

@section('content')
<div class="row">
  <div class="orbit" role="region" aria-label="New SSS Features" data-orbit>
    <ul class="orbit-container">
      <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
      <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
      <li class="is-active orbit-slide">
        <img class="orbit-image" src="{{ asset('images/SSSLogo.png') }}" alt="Space">
        <figcaption class="orbit-caption">ShortStoryServer、再誕。</figcaption>
      </li>
      <li class="orbit-slide">
        <img class="orbit-image" src="{{ asset('images/laravel-text-logo.png') }}" alt="Space">
        <figcaption class="orbit-caption">Laravel 5、はじめました。</figcaption>
      </li>
    </ul>
    <nav class="orbit-bullets">
      <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
      <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
    </nav>
  </div>
</div>

<div class="row text-center">
  <h1>新生ShortStoryServer</h1>
  <p>想像を書き起こす場所、今再び。</p>
  
  <hr>
  
  <p>
    <strong>現在オープンβ状態です。</strong><br>
    記録されたデータが予告なく削除・変更・破壊されることが多々あります。
  </p>

  <hr>

  <h2>新機能ぞくぞく</h2>
  <p class="with-emoji">
    <a href="http://emojione.com/">EmojiOne</a>ライブラリによって、
    :sparkles:このように:sparkles:絵文字を使えるようになりました。:smile:<br>
    Unicode絵文字を使用することもできますが、&#058;smlie&#058;というようにshortnameで記述することも
    できます。
  </p>
</div>
@endsection
