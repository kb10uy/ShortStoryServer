<div class="reveal" id="{{ $id }}" data-reveal data-close-on-click="true" data-animation-in="fade-in" data-animation-out="fade-out">
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
  <h1>{{ $title }}</h1>
  <p class="lead">{{ $message }}</p>
  <div class="button-group">
    <div class="button-group">
      <button class="button" type="submit" form="{{ $id }}-form">{{ $confirm }}</a>
      <button class="button" data-close aria-label="Close modal" type="button">@lang('view.post.cancel')</a>
    </div>
  </div>

  <form method="POST" action="{{ $action }}" id="{{ $id }}-form">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="{{ $method }}">
  </form>
</div>
