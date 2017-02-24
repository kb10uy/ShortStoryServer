const { mix } = require('laravel-mix');
mix.disableNotifications();

// watchじゃなくても差分ビルド有効化
// extractはfoundation-sitesだけappに残すことで対処(どうにかしてくれWebpackさん)
mix.webpackConfig({
  cache: true
});

mix.autoload({});
mix.js('resources/assets/js/app.js', 'public/js')
   .extract(['vue', 'axios', 'lodash', 'jquery', 'laravel-echo', 'pusher-js']);

mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.copy('resources/assets/images', 'public/images');
