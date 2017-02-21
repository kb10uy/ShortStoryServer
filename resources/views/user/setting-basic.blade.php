<h3>基本情報</h3>
<form role="form" method="POST" action="{{ route('user.update.basic') }}" data-abide novalidate>
  {{ csrf_field() }}
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.auth.username')</label>
    </div>
    <div class="small-9 columns">
      <input type="text" name="name" placeholder="使用したいユーザー名" required value="{{ Auth::user()->name }}">
      <span class="form-error">ユーザー名は入力してください。</span>
    </div>
  </div>
  
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.auth.email')</label>
    </div>
    <div class="small-9 columns">
      <input type="text" name="email" placeholder="メールアドレス" required value="{{ Auth::user()->email }}">
      <span class="form-error">メールアドレスは入力してください。</span>
    </div>
  </div>
  
  <div class="row">
    <div class="small-3 columns">
      <label for="right-label" class="text-right middle">@lang('view.user.description')</label>
    </div>
    <div class="small-9 columns">
      <textarea name="description" placeholder="自己紹介的な文章を入力してください。(200文字以内)">{{ Auth::user()->description }}</textarea>
    </div>
  </div>
  
  <div class="row">
    <div class="small-9 small-offset-3 columns">
      <button class="button" type="submit" value="Submit">更新</button>
    </div>
  </div>
</form>