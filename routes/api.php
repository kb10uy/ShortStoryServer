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
users
  + show
  + bookmarks
  + posts
  
posts
  + show
  + list
  - create
  - update 
  - delete 
  + nice
  + bad
  + dopyulicate

bookmarks
  + show
  + list
  - create
  + add
  + pluck
  - delete
  
tags
  - show
  - list

search
  - post
  - bookmark
  - user
*/

Route::group(['namespace' => 'Api'], function () {
    // /foobar => FoobarApi@method
    // でおｋ

    // Admin グループ
    Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {
        Route::post('request', 'AdminApi@request');
        Route::get('users', 'AdminApi@users');
        Route::post('broadcast_server_message', 'AdminApi@broadcastServerMessage');
    });

    // Users グループ
    Route::group(['prefix' => 'users'], function () {
        Route::get('show', 'UsersApi@show');
        Route::get('bookmarks', 'UsersApi@bookmarks');
        Route::get('posts', 'UsersApi@posts');
        Route::group(['middleware' => 'auth:api'], function () {
        });
    });

    // Posts グループ
    Route::group(['prefix' => 'posts'], function () {
        Route::get('show', 'PostsApi@show');
        Route::get('list', 'PostsApi@list');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::patch('nice', 'PostsApi@nice');
            Route::patch('bad', 'PostsApi@bad');
            Route::post('dopyulicate', 'PostsApi@dopyulicate');
        });
    });

    // Bookmarks グループ
    Route::group(['prefix' => 'bookmarks'], function () {
        Route::get('show', 'BookmarksApi@show');
        Route::get('list', 'BookmarksApi@list');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::patch('add', 'BookmarksApi@add');
            Route::patch('pluck', 'BookmarksApi@pluck');
        });
    });
});
