<?php

use App\Http\Controllers\SitemapController;
use App\Mail\Export\CsvExported;
use Illuminate\Support\Facades\Route;

Route::get('sitemaps', SitemapController::class);

Route::view('/', 'welcome')->name('welcome');

require __DIR__.'/home.php';
require __DIR__.'/open.php';
require __DIR__.'/settings.php';

Route::get('/mail/preview', function () {
    return new CsvExported([]);
})->can('admin');
