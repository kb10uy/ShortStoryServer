<div class="top-bar">
  <div class="top-bar-title">
    ShortStoryServer
  </div>
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      
    </ul>
  </div>
  
  <div class="top-bar-right">
    <ul class="dropdown menu" data-dropdown-menu>
      <li>
        @if(Auth::guest())
        <a href="#">@lang('view.not_loggedin')</a>
        <ul class="menu vertical">
          <li><a href="{{ route('login') }}">@lang('view.login')</a></li>
          <li><a href="{{ route('register') }}">@lang('view.register_user')</a></li>
        </ul>
        @else
        <a href="#">{{ Auth::user()->name }}</a>
        <ul class="menu vertical">
          <li>
            <a href="{{ route('user.profile', ['user' => Auth::user()->name]) }}">@lang('view.user.profile')</a>
            <a href="{{ route('user.setting') }}">@lang('view.title.setting')</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">@lang('view.auth.logout')</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              {{ csrf_field() }}
            </form>
          </li>
        </ul>
        @endif
      </li>
    </ul>
  </div>
</div>