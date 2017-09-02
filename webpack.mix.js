/*global Config */
const { mix } = require('laravel-mix');
mix.disableNotifications();

// watchじゃなくても差分ビルド有効化
mix.webpackConfig({
  cache: true,
  module: {
    rules: [
      {
        //ESLint用
        enforce: 'pre',
        test: /\.(vue|jsx?)$/,
        loader: 'eslint-loader',
        exclude: /node_modules/
      },
      {
        /*
         * このルールが追加されている背景
         * 1. UglifyJsPluginがES6に対応してない
         * 2. 実はそんなことはなくて1.0.0(これ書いてる時点で未リリース)ではuglifyjs3ベースで
         *    ES6記法に対応してる
         * 3. Laravel Mixが依然として0.4.6を指してるのでアプデ出来ない
         * 4. webpack-rules.jsからコピーしてしのいでる
         */
        test: /\.jsx?$/,
        include: /foundation-sites/,
        use: [
          {
            loader: 'babel-loader',
            options: Config.babel()
          }
        ]
      }
    ]
  }
});

mix.autoload({});
mix
  .js('resources/assets/js/app.js', 'public/js')
  .js('resources/assets/js/user.js', 'public/js')
  .js('resources/assets/js/bootstrap.js', 'public/js')
  .extract(['vue', 'axios', 'lodash', 'jquery', 'laravel-echo', 'foundation-sites']);

mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.copy('resources/assets/images', 'public/images');
