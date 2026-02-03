<?php

use App\Http\Controllers\Home\AccountController;
use Illuminate\Support\Facades\Route;

/**
 * Authenticated Routes
 */
Route::middleware(['auth', 'verified'])->prefix('home')->group(function () {
    Route::livewire('/', 'pages::home.home')
        ->name('home');

    Route::livewire('timeline', 'pages::home.timeline.index')
        ->name('home.timeline');

    Route::livewire('timeline/{username}@{domain}', 'pages::home.timeline.acct')
        ->name('home.timeline.acct');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('accounts', [AccountController::class, 'redirect'])
        ->name('accounts.add');

    Route::get('accounts/callback', [AccountController::class, 'callback'])
        ->name('accounts.callback');
});
