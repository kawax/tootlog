<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('sitemaps', SitemapController::class);

Route::view('/', 'welcome')->name('welcome');

require __DIR__.'/home.php';
require __DIR__.'/open.php';
