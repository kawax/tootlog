<?php

use App\Http\Controllers\Home\AccountController;
use App\Http\Controllers\Home\AccountDeleteController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

/**
 * Authenticated Routes
 */

Route::middleware(['auth', 'verified'])->prefix('home')->group(function () {
    Volt::route('/', 'home.home')
        ->name('home');

    Volt::route('timeline', 'home.timeline.index')
        ->name('home.timeline');

    Volt::route('timeline/{username}@{domain}', 'home.timeline.acct')
        ->name('home.timeline.acct');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('accounts', [AccountController::class, 'redirect'])
        ->name('accounts.add');

    Route::get('accounts/callback', [AccountController::class, 'callback'])
        ->name('accounts.callback');

    Route::delete('accounts/delete/{account}', AccountDeleteController::class)->name('accounts.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
    Volt::route('settings/export', 'settings.export')->name('settings.export');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
