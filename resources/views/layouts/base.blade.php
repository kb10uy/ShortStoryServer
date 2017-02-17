<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="{{ mix('/js/manifest.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/js/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    <script type="text/javascript" src="{{ mix('/js/common.js') }}"></script>
    <title>@yield('title') - ShortStoryServer</title>
  </head>
  <body>
    <div id="app">
      @include('layouts.topbar')
      
      @yield('content')
    </div>
  </body>
</html>
