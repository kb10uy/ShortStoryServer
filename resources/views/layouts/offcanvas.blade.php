<ul class="vertical menu" data-accordion-menu>
  <li><a href="{{ route('home') }}">@lang('view.title.home')</a></li>
  <li>
    <a href="#">@lang('view.title.explore')</a>
    <ul class="nested vertical menu">
      <li><a href="{{ route('about') }}">@lang('view.title.about')</a></li>
      <li><a href="{{ route('post.list') }}">@lang('view.title.posts_list')</a></li>
      <li><a href="{{ route('post.search') }}">@lang('view.title.search')</a></li>
    </ul>
  </li>
  <li>
    @if(Auth::guest())
    <a href="#">@lang('view.not_loggedin')</a>
    <ul class="menu vertical nested">
      <li><a href="{{ route('login') }}">@lang('view.title.login')</a></li>
      <li><a href="{{ route('register') }}">@lang('view.title.register_user')</a></li>
    </ul>
    @else
    <a href="#">{{ Auth::user()->name }}</a>
    <ul class="menu vertical nested">
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

<hr class="raw">

@yield('mobile-offcanvas')
