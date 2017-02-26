@extends('layouts.base')
@section('title', __('view.title.about'))

@section('content')
<div class="row">
  <h1>@lang('view.about.title')</h1>

  <p>
    ShortStoryServerは、主にSS(ショートストーリー)を投稿できるサービスですが、
    個人的なポエム、特に○iitaに書きたくても書けなかったあんなことやこんなことを書くのにも
    適しています。
  </p>
</div>
@endsection