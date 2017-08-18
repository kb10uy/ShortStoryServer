<h3>@lang('view.user.basic_info')</h3>
<form role="form" method="POST" action="{{ route('user.update.basic') }}" data-abide novalidate>
  {{ csrf_field() }}
  <div class="grid-x grid-padding-x">
    <div class="small-3 cell">
      <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
    </div>
    <div class="small-9 cell">
      <input type="text" name="name" placeholder="@lang('view.auth.username_p')" required value="{{ Auth::user()->name }}">
      <span class="form-error">@lang('view.message.username_required')</span>
    </div>
  </div>
  
  <div class="grid-x grid-padding-x">
    <div class="small-3 cell">
      <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
    </div>
    <div class="small-9 cell">
      <input type="text" name="email" placeholder="@lang('view.auth.email')" required value="{{ Auth::user()->email }}">
      <span class="form-error">@lang('view.message.email_required')</span>
    </div>
  </div>
  
  <div class="grid-x grid-padding-x">
    <div class="small-3 cell">
      <label for="right-label" class="text-right middle">@lang('view.user.description')</label>
    </div>
    <div class="small-9 cell">
      <textarea name="description" placeholder="@lang('view.user.description_p')">{{ Auth::user()->description }}</textarea>
    </div>
  </div>
  
  <div class="grid-x grid-padding-x">
    <div class="small-9 small-offset-3 cell">
      <button class="button" type="submit" value="Submit">@lang('view.update')</button>
    </div>
  </div>
</form>