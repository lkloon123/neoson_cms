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

Auth::routes(['verify' => true]);

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');

Route::prefix('api')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::options('version', 'AdminController@version');
        Route::get('me', 'UserController@getMe');

        Route::get('page/search', 'PageController@search');
        Route::resource('page', 'PageController')->except(['create', 'edit']);

        Route::resource('menu', 'MenuController')->except(['create', 'edit']);
    });
});

Route::get('/', 'PageController@home');
Route::get('{slug}', 'PageController@getPage')->where('slug', '([A-Za-z0-9\-\/]+)');
