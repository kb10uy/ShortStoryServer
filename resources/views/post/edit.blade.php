@extends('layouts.base')

@section('title', __('view.title.edit_post'))

@section('content')
<div class="grid-x">
  <h1>@lang('view.title.edit_post')</h1>
</div>

<div class="grid-x">
  <div class="cell">
    <form role="form" method="POST" action="{{ route('post.edit', ['id' => $post->id]) }}" novalidate data-abide>
      {{ csrf_field() }}
      <input name="_method" type="hidden" value="PATCH">
      <label>
        @lang('view.post.title')
        <input name="title" required type="text" placeholder="{{ __('view.post.title_p') }}" value="{{ $post->title }}">
        <span class="form-error">@lang('view.message.title_required')</span>
      </label>
      
      <input name="_prev_tags" id="post_hidden_tags" type="hidden" value="{{ $taglist }}">
      <label>
        @lang('view.post.tag')
        <sss-post-tags></sss-post-tags>
      </label>
      
      <label>
        @lang('view.post.type')
        <select name="type">
          <option value="plain" {{ $post->type == 'plain' ? 'selected' : '' }}>@lang('view.post.type_plain')</option>
          <option value="s3wf" {{ $post->type == 's3wf' ? 'selected' : '' }}>@lang('view.post.type_s3wf')</option>
        </select>
      </label>

      <label>
        @lang('view.post.text')
        <textarea name="text" required rows="32" placeholder="{{ __('view.post.text_p') }}">{{ $post->text }}</textarea>
        <span class="form-error">@lang('view.message.title_required')</span>
      </label>
      
      <button class="button" type="submit">@lang('view.update')</button>
    </form>
  </div>
</div>
@endsection