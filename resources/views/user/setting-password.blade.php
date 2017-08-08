<h3>@lang('view.user.password_update')</h3>
<form role="form" method="POST" action="{{ route('user.update.password') }}" data-abide novalidate>
  {{ csrf_field() }}
  
  <div class="grid-x">
    <div class="small-3 cell">
      <label for="right-label" class="text-right middle">@lang('view.user.cur_password')</label>
    </div>
    <div class="small-9 cell">
      <input id="password" type="password" name="password" required>
      <span class="form-error">@lang('view.message.password_required')</span>
    </div>
  </div>
  
  <div class="grid-x">
    <div class="small-3 cell">
      <label for="right-label" class="text-right middle">@lang('view.user.new_password')</label>
    </div>
    <div class="small-9 cell">
      <input id="password_new" type="password" name="password_new" required>
      <span class="form-error">@lang('view.message.new_password_required')</span>
    </div>
  </div>
  <div class="grid-x">
    <div class="small-3 cell">
      <label for="right-label" class="text-right middle">@lang('view.user.new_password_confirm')</label>
    </div>
    <div class="small-9 cell">
      <input type="password" name="password_new_confirmation" required data-equalto="password_new">
      <span class="form-error">@lang('view.message.password_nomatch')</span>
    </div>
  </div>
  
  <div class="grid-x">
    <div class="small-9 small-offset-3 cell">
      <button class="button" type="submit" value="Submit">@lang('view.update')</button>
    </div>
  </div>
</form>