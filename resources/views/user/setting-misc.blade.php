<h3>@lang('view.user.additional_info')</h3>
<form role="form" method="POST" action="{{ route('user.update.misc') }}" data-abide novalidate>
  {{ csrf_field() }}
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.user.birthday')</label>
    </div>
    <div class="small-9 columns">
      <input type="date" name="birthday" required value="{{ Auth::user()->birthday }}">
    </div>
  </div>
  
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.user.url')</label>
    </div>
    <div class="small-9 columns">
      <input type="text" name="url" placeholder="@lang('view.user.url_p')" value="{{ Auth::user()->url }}">
    </div>
  </div>
  
  <div class="row">
    <div class="small-9 small-offset-3 columns">
      <button class="button" type="submit" value="Submit">@lang('view.update')</button>
    </div>
  </div>
</form>