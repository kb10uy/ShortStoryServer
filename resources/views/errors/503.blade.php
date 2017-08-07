<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.includes')
    <title>ShortStoryServer is currently down.</title>
  </head>
  <body>
    <!-- 本体 -->
    <div id="app">
      <div id="content" class="grid-container">
        <h1 class="text-center">
          <strike>ShortStoryServer</strike>
        </h1>
        <p class="text-center">
          @lang('view.status.' . ($exception->getMessage() ?: 'down'))
        </p>
        <p class="text-center">
          ShortStoryServer is down since:
          <div class="stat text-center">
            {{ $exception->wentDownAt->formatLocalized('%m/%e %H:%M:%S') }}
          </div>
        </p>
        
      </div>
    </div>
  </body>
</html>
