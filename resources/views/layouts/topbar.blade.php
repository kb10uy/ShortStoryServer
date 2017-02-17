<div class="top-bar">
  <div class="top-bar-title">
    ShortStoryServer
  </div>
  <div class="top-bar-left">
    <ul class="dropdown menu" data^dropdown menu>
      
    </ul>
  </div>
  
  <div class="top-bar-right">
    <ul class="dropdown menu" data-dropdown-menu>
      <li>
        <a href="#">@lang('view.not_loggedin')</a>
        <ul class="menu vertical">
          <li><a href="{{ secure_url('/login') }}">@lang('view.login')</a></li>
          <li><a href="{{ secure_url('/user/register') }}">@lang('view.register_user')</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>