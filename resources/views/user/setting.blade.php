@extends('layouts.base')

@section('title', '設定')

@section('content')
<div class="row">
  <h1>設定</h1>
  @if($errors->any())
    <div data-abide-error class="warning callout">
      <ul>
        @foreach($errors->all() as $message)
          <li>{{ $message }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if(Session::has('basic_updated'))
    <div data-abide-error class="success callout">
      {{ Session::get('basic_updated') }}
    </div>
  @endif
  @if(Session::has('password_updated'))
    <div data-abide-error class="success callout">
      {{ Session::get('password_updated') }}
    </div>
  @endif
  @if(Session::has('icon_uploaded'))
    <div data-abide-error class="success callout">
      {{ Session::get('icon_uploaded') }}
    </div>
  @endif
</div>

<div class="row collapse">
  <div class="medium-3 columns">
    <ul class="tabs vertical" id="tabs-setting" data-tabs>
      <li class="tabs-title is-active"><a href="#panel-basic" aria-selected="true">基本設定</a></li>
      <li class="tabs-title"><a href="#panel-icon">アイコン</a></li>
    </ul>
    </div>
    <div class="medium-9 columns">
    <div class="tabs-content vertical" data-tabs-content="tabs-setting">
      <div class="tabs-panel is-active" id="panel-basic">
        <!-- 基本情報 1 -->
        @include('user.setting-basic')
        
        <!-- 基本情報 2 -->
        @include('user.setting-password')
      </div>
      
      <!-- アイコン -->
      <div class="tabs-panel" id="panel-icon">
        <div class="row" data-equalizer data-equalize-on="medium">
          @include('user.setting-icon')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection