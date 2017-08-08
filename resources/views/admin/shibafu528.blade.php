@extends('layouts.base')
@section('title', 'Admin/shibafu528')

@section('content')
<div class="cell">
  <h1>@shibafu528 update_icon</h1>
  <form role="form" method="POST" action="{{ route('admin.shibafu528') }}">
    <input name="color" type="text">
    <input type="submit" class="button" value="ツイート">
  </form>
</div>
@endsection