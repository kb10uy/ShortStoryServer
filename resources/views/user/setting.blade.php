@extends('layouts.base')

@section('title', __('view.title.setting'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.title.setting')</h1>
</div>

<div class="grid-x collapse">
  <div class="medium-3 cell">
    <ul class="tabs vertical" id="tabs-setting" data-tabs>
      <li class="tabs-title is-active"><a href="#panel-basic" aria-selected="true">@lang('view.user.basic_setting')</a></li>
      <li class="tabs-title"><a href="#panel-icon">@lang('view.user.icon')</a></li>
      <li class="tabs-title"><a href="#panel-misc">@lang('view.user.misc')</a></li>
      <li class="tabs-title"><a href="#panel-social">@lang('view.user.social')</a></li>
      <li class="tabs-title"><a href="#panel-api">@lang('view.user.api')</a></li>
    </ul>
    </div>
    <div class="medium-9 cell">
    <div class="tabs-content vertical" data-tabs-content="tabs-setting">
      <div class="tabs-panel is-active" id="panel-basic">
        <!-- 基本情報 1 -->
        @include('user.setting-basic')
        
        <!-- 基本情報 2 -->
        @include('user.setting-password')
      </div>
      
      <!-- アイコン -->
      <div class="tabs-panel" id="panel-icon">
        <div class="grid-x grid-padding-x">
          @include('user.setting-icon')
        </div>
      </div>
      
      <div class="tabs-panel" id="panel-misc">
        <!-- 追加情報 -->
        @include('user.setting-misc')
      </div>
      
      <div class="tabs-panel" id="panel-social">
        <!-- 連携設定 -->
        @include('user.setting-social')
      </div>

      <div class="tabs-panel" id="panel-api">
        <!-- API設定 -->
        @include('user.setting-oauth')
      </div>
    </div>
  </div>
</div>
@endsection