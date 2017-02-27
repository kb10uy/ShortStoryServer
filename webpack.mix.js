const { mix } = require('laravel-mix');
mix.disableNotifications();

// watchじゃなくても差分ビルド有効化
mix.webpackConfig({
  cache: true
});

mix.autoload({});
mix.js('resources/assets/js/app.js', 'public/js')
   .extract(['vue', 'axios', 'lodash', 'jquery', 'laravel-echo', 'pusher-js']);
mix.js('resources/assets/js/user.js', 'public/js')
   .js('resources/assets/js/admin.js', 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.copy('resources/assets/images', 'public/images');
