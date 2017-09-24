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

//Admin
Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/admin', 'AdminController@index')->name('admin.index');
});

//ユーザー認証関係
Auth::routes();

//Twitter連携
Route::get('/login/twitter', 'Auth\SocialLoginController@redirectToTwitter')
     ->name('login.twitter');
Route::get('/login/twitter/callback', 'Auth\SocialLoginController@handleTwitterCallback')
     ->name('login.twitter.callback');
Route::delete('/login/twitter/remove', 'Auth\SocialLoginController@removeTwitterData')
     ->name('login.twitter.remove')->middleware('auth');

//GitHub連携
Route::get('/login/github', 'Auth\SocialLoginController@redirectToGitHub')
     ->name('login.github');
Route::get('/login/github/callback', 'Auth\SocialLoginController@handleGitHubCallback')
     ->name('login.github.callback');
Route::delete('/login/github/remove', 'Auth\SocialLoginController@removeGitHubData')
     ->name('login.github.remove')->middleware('auth');

//ホーム
Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');

//投稿
Route::group(['middleware' => 'auth'], function () {
    Route::get('/post/new', 'PostEditController@create')->name('post.new');
    Route::post('/post/new', 'PostEditController@upload')->name('post.new');
    Route::get('/post/{id}/edit', 'PostEditController@edit')->name('post.edit');
    Route::patch('/post/{id}/edit', 'PostEditController@update')->name('post.edit');
    Route::delete('/post/{id}/delete', 'PostEditController@delete')->name('post.delete');
});
Route::get('/post', 'PostController@list')->name('post.list');
Route::get('/post/search', 'PostController@search')->name('post.search');
Route::get('/post/{id}', 'PostController@view')->name('post.view');

//ブックマーク
// Route::get('/bookmark', 'BookmarkController@list')->name('bookmark.list');
// Route::get('/bookmark/search', 'BookmarkController@search')->name('bookmark.search');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/bookmark/add/{id}', 'BookmarkController@showAddView')->name('bookmark.showadd');
    Route::patch('/bookmark/add', 'BookmarkController@addToBookmark')->name('bookmark.add');
    Route::get('/bookmark/create', 'BookmarkController@showCreateView')->name('bookmark.create');
    Route::post('/bookmark/create', 'BookmarkController@create')->name('bookmark.create');
    Route::get('/bookmark/{id}/edit', 'BookmarkController@edit')->name('bookmark.edit');
});
Route::get('/bookmark/user/{user}', 'BookmarkController@listUser')->name('bookmark.user');
Route::get('/bookmark/{id}', 'BookmarkController@view')->name('bookmark.view');

//ユーザー
Route::get('/user/{user}', 'UserController@profile')->name('user.profile');

//設定
Route::group(['middleware' => 'auth'], function () {
    Route::get('/setting', 'UserController@setting')->name('user.setting');
    Route::post('/update/basic', 'UserSettingController@updateBasic')->name('user.update.basic');
    Route::post('/update/password', 'UserSettingController@updatePassword')->name('user.update.password');
    Route::post('/update/icon', 'UserSettingController@updateIcon')->name('user.update.icon');
    Route::post('/update/misc', 'UserSettingController@updateMisc')->name('user.update.misc');
});
