<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.includes')
    <title>ShortStoryServer Token Mismatched.</title>
  </head>
  <body>
    <!-- 本体 -->
    <div id="app">
      <div id="content" class="grid-container">
        <h1 class="text-center">
          <i>ShortStoryServer</i>
        </h1>
        <p class="text-center">
          @lang('view.status.token_expired')
        </p>
      </div>
    </div>
  </body>
</html>
