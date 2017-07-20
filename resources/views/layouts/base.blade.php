<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.includes')
    <title>@yield('title') - ShortStoryServer</title>
  </head>
  <body>
    <!-- 本体 -->
    <div id="app">
      @if(Agent::isMobile())
        <!-- モバイル用body -->
        <div class="off-canvas position-left" id="offCanvas" data-off-canvas>
           @include('layouts.offcanvas')
        </div>
        <div id="content"  class="off-canvas-content" data-off-canvas-content>
          @include('layouts.topbar-mobile')
          @include('layouts.flashes')
          <div class="grid-container">
            @yield('content')
          </div>
        </div>

        <!--
        <footer id="footer">
          @include('layouts.footer')
        </footer>
        -->
        <popup-info name="server"></popup-info>
      @else
        <!-- デスクトップ用body -->
        <div id="content">
          @include('layouts.topbar')
          @include('layouts.flashes')
        
          <div class="grid-container">
            @yield('content')
          </div>
        </div>
        <!--
        <footer id="footer">
          @include('layouts.footer')
        </footer>
        -->
        <popup-info name="server"></popup-info>
      @endif
    </div>

    @include('layouts.includes-after')
  </body>
</html>
