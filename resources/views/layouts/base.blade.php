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
      @include('layouts.topbar')
      @include('layouts.flashes')
      
      @yield('content')
      @include('layouts.misc')
    </div>
    
    @include('layouts.includes-after')
  </body>
</html>
