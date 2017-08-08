@extends('layouts.base')
@section('title', 'Admin')

@section('content')
  <div class="grid-x">
    <h1>Admin</h1>
  </div>
  <div class="grid-x collapse">
    <div class="medium-3 cell">
      <ul class="tabs vertical" id="admin-tabs" data-tabs>
        <li class="tabs-title is-active"><a href="#admin-panel1" aria-selected="true">ユーザー管理</a></li>
        <li class="tabs-title"><a href="#admin-panel2">投稿管理</a></li>
        <li class="tabs-title"><a href="#admin-panel3">サーバー管理</a></li>
        <li class="tabs-title"><a href="#admin-panel4">その他</a></li>
        <li class="tabs-title"><a href="#admin-panel5">芝生</a></li>
      </ul>
    </div>
    <div class="medium-9 cell">
      <div class="tabs-content vertical" data-tabs-content="admin-tabs">
        <div class="tabs-panel is-active" id="admin-panel1">
          <h2>ユーザー管理</h2>
          <admin-user-tab></admin-user-tab>
        </div>
        <div class="tabs-panel" id="admin-panel2">
          <h2>投稿管理</h2>
          <admin-post-tab></admin-post-tab>
        </div>
        <div class="tabs-panel" id="admin-panel3">
          <h2>サーバー管理</h2>
          <admin-server-tab></admin-server-tab>
        </div>
        <div class="tabs-panel" id="admin-panel4">
          <h2>その他</h2>
        </div>
        <div class="tabs-panel" id="admin-panel5">
          <h2>芝生</h2>
        </div>
      </div>
    </div>
  </div>
@endsection