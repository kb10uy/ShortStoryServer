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

//ユーザー認証関係
Auth::routes();

Route::get('/login/twitter', 'LoginController@redirectToTwitter')
     ->name('login.twitter');
Route::get('/login/twitter/callback', 'LoginController@handleTwitterCallback')
     ->name('login.twitter.callback');

Route::get('/login/github', 'LoginController@redirectToGitHub')
     ->name('login.github');
Route::get('/login/github/callback', 'LoginController@handleGitHubCallback')
     ->name('login.github.callback');