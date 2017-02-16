const { mix } = require('laravel-mix');
mix.disableNotifications();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// watchじゃなくても差分ビルド有効化
// extractはfoundation-sitesだけappに残すことで対処(どうにかしてくれWebpackさん)

mix.webpackConfig({
  cache: true
});

mix.autoload({
  // jquery: ['$', 'window.jQuery']
});
mix.js('resources/assets/js/app.js', 'public/js')
   .extract(['vue', 'axios', 'lodash', 'jquery']);
mix.sass('resources/assets/sass/app.scss', 'public/css');
