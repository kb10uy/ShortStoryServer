<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
API ルート表
/api
+---/admin
|   +---/request (POST) Admin権限を要求する
|   +---/message (POST) サーバーメッセージを発行する
|   +---/users (GET) ユーザーのリストを取得する
+---/app
    +---/create (POST) アプリケーションの作成

*/

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api',
    ], function () {
    // /foobar => FoobarApi@method
    // でおｋ

    // Admin グループ
    Route::group(['prefix' => 'admin'], function() {
        Route::post('request', 'AdminApi@request');
        Route::get('users', 'AdminApi@users');
        Route::post('broadcast_server_message', 'AdminApi@broadcastServerMessage');
    });

    // Users グループ
    Route::group(['prefix' => 'users'], function() {
        Route::get('get', 'UsersApi@get');
        Route::get('query', 'UsersApi@query');
    });

    // Posts グループ
    Route::group(['prefix' => 'posts'], function() {
        Route::get('get', 'PostsApi@get');
        Route::patch('nice', 'PostsApi@nice');
        Route::post('dopyulicate', 'PostsApi@dopyulicate');
    });
});
