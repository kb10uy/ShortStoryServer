@extends('layouts.base')
@section('title', __('view.title.authorization'))

@section('content')
<div class="grid-x grid-padding-x">
  <h1>アプリケーションの認証リクエスト</h1>
  <div class="large-6 small-12 cell">
    <strong>{{ $client->name }}</strong>があなたのアカウントの認証を要求しています。
    許可してもよろしいですか?
  </div>
  <div class="large-6 small-12 cell">
    このアプリケーションに許可される操作は以下のとおりです:
    <ul>
      @if(count($scopes) > 0)
        @foreach($scopes as $scope)
          <li>{{ $scope->description }}</li>
        @endforeach
      @else
        <li>全て。(流石にパスワードとかは見ないよ)</li>
      @endif
    </ul>
  </div>
  <div class="small-6 cell">
    <button type="submit" class="expanded button" form="form-authorize">許可する</button>
  </div>
  <div class="small-6 cell">
    <button type="submit" class="expanded alert button" form="form-cancel">キャンセル</button>
  </div>

  <form action="/oauth/authorize" method="post" id="form-authorize">
    {{ csrf_field() }}
    <input type="hidden" name="state" value="{{ $request->state }}">
    <input type="hidden" name="client_id" value="{{ $client->id }}">
  </form>

  <form action="/oauth/authorize" method="post" id="form-cancel">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <input type="hidden" name="state" value="{{ $request->state }}">
    <input type="hidden" name="client_id" value="{{ $client->id }}">
  </form>
</div>
@endsection
