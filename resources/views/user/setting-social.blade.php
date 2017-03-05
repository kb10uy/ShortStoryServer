<h3>@lang('view.user.additional_info')</h3>
<div class="row">
  <div class="small-3 columns">
    <label for="right-label" class="text-right middle">@lang('view.user.twitter')</label>
  </div>
  <div class="small-3 columns">
    <label class="middle">{{ Auth::user()->twitter_name ?: __('view.user.unset') }}</label>
  </div>
  <div class="small-6 columns">
    <form role="form" method="POST" action="{{ route('login.twitter.remove') }}">
      <a class="button" href="{{ route('login.twitter') }}">@lang('view.user.set')</a>
      
      {{ csrf_field() }}
      <input name="_method" type="hidden" value="DELETE">
      <button class="button" type="submit" value="Submit">@lang('view.user.unlink')</button>
    </form>
  </div>
</div>

<div class="row">
  <div class="small-3 columns">
    <label for="right-label" class="text-right middle">@lang('view.user.github')</label>
  </div>
  <div class="small-3 columns">
    <label class="middle">{{ Auth::user()->github_name ?: __('view.user.unset') }}</label>
  </div>
  <div class="small-6 columns">
    <form role="form" method="POST" action="{{ route('login.github.remove') }}">
      <a class="button" href="{{ route('login.github') }}">@lang('view.user.set')</a>
      
      {{ csrf_field() }}
      <input name="_method" type="hidden" value="DELETE">
      <button class="button" type="submit" value="Submit">@lang('view.user.unlink')</button>
    </form>
  </div>
</div>