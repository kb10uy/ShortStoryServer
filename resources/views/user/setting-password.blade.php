<h3>パスワードの更新</h3>
<form role="form" method="POST" action="{{ route('user.update.password') }}" data-abide novalidate>
  {{ csrf_field() }}
  
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.user.cur_password')</label>
    </div>
    <div class="small-9 columns">
      <input id="password" type="password" name="password" required>
      <span class="form-error">今のパスワードを入力してください。</span>
    </div>
  </div>
  
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.user.new_password')</label>
    </div>
    <div class="small-9 columns">
      <input id="password_new" type="password" name="password_new" required>
      <span class="form-error">新しいパスワードを入力してください。</span>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.user.new_password_confirm')</label>
    </div>
    <div class="small-9 columns">
      <input type="password" name="password_new_confirmation" required data-equalto="password_new">
      <span class="form-error">パスワードが一致していません。</span>
    </div>
  </div>
  
  <div class="row">
    <div class="small-9 small-offset-3 columns">
      <button class="button" type="submit" value="Submit">更新</button>
    </div>
  </div>
</form>