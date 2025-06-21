<?php

use App\Http\Controllers\Home\AccountController;
use App\Http\Controllers\Home\AccountDeleteController;
use App\Http\Controllers\Home\ExportController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PreferencesController;
use App\Http\Controllers\Home\TimelineController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('accounts', [AccountController::class, 'redirect'])
        ->name('accounts.add');

    Route::get('accounts/callback', [AccountController::class, 'callback'])
        ->name('accounts.callback');

    Route::delete('accounts/delete/{account}', AccountDeleteController::class)->name('accounts.delete');

    Route::get('timeline', [TimelineController::class, 'index'])->name('timeline');

    Route::get('timeline/{username}@{domain}', [TimelineController::class, 'acct'])->name('timeline.account');

    Route::singleton('preferences', PreferencesController::class)->except('edit');

    Route::post('export/csv', ExportController::class)->name('export.csv');

    Route::get('home', HomeController::class)->name('home');
});

Route::get('instances', InstanceController::class)->name('instances');

Route::get('sitemaps', SitemapController::class);

Route::view('/', 'welcome')->name('welcome');

Route::view('usage', 'pages.usage');

Route::view('en/usage', 'pages.en.usage');

require __DIR__.'/open.php';
