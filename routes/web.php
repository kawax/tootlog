<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now redirect something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();

Route::middleware('auth')->group(function () {
    Route::name('accounts.add')->post('accounts', 'AccountController@redirect');
    Route::get('accounts/callback', 'AccountController@callback');

    Route::name('timeline')->get('timeline', 'TimelineController@index');
    Route::name('timeline.account')->get('timeline/{username}@{domain}', 'TimelineController@acct');

    Route::get('home', 'HomeController@index');
});

Route::middleware('auth')->namespace('Api')->prefix('api')->group(function () {
    Route::delete('status/hide/{status}', 'StatusController@hide');
    Route::put('status/show/{status}', 'StatusController@show');

    Route::get('accounts', 'AccountController@index');
});

Route::namespace('Open')->group(function () {
    Route::name('open.user')->get('@{user}', 'UserController@index');
    Route::name('open.account.index')->get('@{user}/{username}@{domain}', 'AccountController@index');
    Route::name('open.account.show')->get('@{user}/{username}@{domain}/{status_id}', 'AccountController@show');
});


Route::get('/', 'WelcomeController');
