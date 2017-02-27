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
|   +---/message (POST) サーバーメッセージを発行する
|   +---/users (GET) ユーザーのリストを取得する
+---/app
    +---/create (POST) アプリケーションの作成

*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
