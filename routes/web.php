<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//デバッグ用

//ホーム
Route::get('/', 'HomeController@index');
Route::get('/user/profile', 'UserController@profile')->name('user.profile');
Route::get('/user/setting', 'UserController@setting')->name('user.setting');

//ユーザー認証関係
Auth::routes();

Route::get('/login/twitter', 'Auth\LoginController@redirectToTwitter')
     ->name('login.twitter');
Route::get('/login/twitter/callback', 'Auth\LoginController@handleTwitterCallback')
     ->name('login.twitter.callback');

Route::get('/login/github', 'Auth\LoginController@redirectToGitHub')
     ->name('login.github');
Route::get('/login/github/callback', 'Auth\LoginController@handleGitHubCallback')
     ->name('login.github.callback');