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
    Route::name('accounts.add')->post('/accounts', 'AccountController@redirect');
    Route::get('/accounts/callback', 'AccountController@callback');

    Route::get('/home', 'HomeController@index');
});

Route::namespace('Open')->group(function () {
    Route::name('open.user')->get('@{user}', 'UserController@index');
});


Route::get('/', 'WelcomeController');
