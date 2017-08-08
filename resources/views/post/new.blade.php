@extends('layouts.base')

@section('title', __('view.title.post'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.title.post')</h1>
</div>

<div class="grid-x">
  <form role="form" method="POST" action="{{ route('post.new') }}" novalidate data-abide>
    {{ csrf_field() }}
    <label>
      @lang('view.post.title')
      <input name="title" required type="text" placeholder="{{ __('view.post.title_p') }}">
      <span class="form-error">@lang('view.message.title_required')</span>
    </label>
    
    <label>
      @lang('view.post.tag')
      <sss-post-tags></sss-post-tags>
    </label>
    
    <label>
      @lang('view.post.type')
      <select name="type">
        <option value="plain">@lang('view.post.type_plain')</option>
        <option value="s3wf">@lang('view.post.type_s3wf')</option>
      </select>
    </label>
    
    <label>
      @lang('view.post.text')
      <textarea name="text" required rows="32" placeholder="{{ __('view.post.text_p') }}"></textarea>
      <span class="form-error">@lang('view.message.title_required')</span>
    </label>
    
    <button class="button" type="submit">@lang('view.t_post')</button>
  </form>
</div>
@endsection