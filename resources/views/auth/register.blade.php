@extends('layouts.base')

@section('title', 'ユーザー登録')

@section('content')
<div class="row">
  <h1>ShortStoryServerアカウントを作成する</h1>
  <p>
    ユーザー登録をすると、SSの投稿やブックマーク、通知などを利用できます！
    早速登録しましょう。
  </p>
</div>
<div class="row">
  <form role="form" method="POST" action="{{ route('register') }}" data-abide novalidate>
    <!-- エラー表示 -->
    <div data-abide-error class="alert callout" style="display: none;">
      (caution) 入力に不備もしくは不都合があります。確認してください。
    </div>
    @if ($errors->has('name'))
      <div data-abide-error class="warning callout">
        {{ $errors->first('name') }}
      </div>
    @endif
    @if ($errors->has('email'))
      <div data-abide-error class="warning callout">
        {{ $errors->first('email') }}
      </div>
    @endif
    
    {{ csrf_field() }}
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
      </div>
      <div class="small-8 columns">
        <input type="text" name="name" placeholder="使用したいユーザー名" required>
        <span class="form-error">ユーザー名は入力してください。</span>
      </div>
    </div>
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
      </div>
      <div class="small-8 columns">
        <input type="text" name="email" placeholder="パスワードリセットなどに使用します" required>
        <span class="form-error">メールアドレスは入力してください。</span>
      </div>
    </div>
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.password')</label>
      </div>
      <div class="small-8 columns">
        <input id="password" type="password" name="password" required>
        <span class="form-error">パスワードは入力してください。</span>
      </div>
    </div>
    <div class="row">
      <div class="small-4 columns">
        <label for="right-label" class="text-right middle">@lang('view.auth.password_confirm')</label>
      </div>
      <div class="small-8 columns">
        <input type="password" name="password_confirmation" required data-equalto="password">
        <span class="form-error">パスワードが一致していません。</span>
      </div>
    </div>
    <div class="input-group-button">
      <input type="submit" class="button expanded" value="@lang('view.auth.register')">
    </div>
  </form>
</div>
@endsection
