
<div class="top-bar">
  <div class="top-bar-title">
    <span data-responsive-toggle="responsive-menu" data-hide-for="medium">
      <button class="menu-icon dark" type="button" data-toggle></button>
    </span>&nbsp;
    ShortStoryServer
  </div>
  {{-- http://foundation.zurb.com/forum/posts/49787-problem-with-dropdown-menu-on-ipad --}}
  <div id="responsive-menu">
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu data-close-on-click-inside="false">
        <li><a href="{{ route('home') }}">@lang('view.title.home')</a></li>
        <li>
          <a href="#">@lang('view.title.explore')</a>
          <ul class="menu vertical">
            <li><a href="{{ route('about') }}">@lang('view.title.about')</a></li>
            <li><a href="{{ route('post.list') }}">@lang('view.title.posts_list')</a></li>
            <li><a href="{{ route('post.search') }}">@lang('view.title.search')</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="top-bar-right">
      <ul class="dropdown menu" data-dropdown-menu data-close-on-click-inside="false">
        <li>
          @if(Auth::guest())
          <a href="#">@lang('view.not_loggedin')</a>
          <ul class="menu vertical">
            <li><a href="{{ route('login') }}">@lang('view.title.login')</a></li>
            <li><a href="{{ route('register') }}">@lang('view.title.register_user')</a></li>
          </ul>
          @else
          <a href="#">{{ Auth::user()->name }}</a>
          <ul class="menu vertical" >
            <li><a href="{{ route('post.new') }}">@lang('view.title.post')</a></li>
            <li><a href="{{ route('user.profile', ['user' => Auth::user()->name]) }}">@lang('view.user.profile')</a></li>
            <li><a href="{{ route('user.setting') }}">@lang('view.title.setting')</a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">@lang('view.auth.logout')</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              {{ csrf_field() }}
            </form>
          </ul>
          @endif
        </li>
      </ul>
    </div>
  </div>
</div>