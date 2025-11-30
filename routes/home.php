<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::middleware(['auth', 'verified'])->prefix('home')->group(function () {
    Volt::route('/', 'home.home')
        ->name('home');

    Volt::route('timeline', 'home.timeline.index')
        ->name('home.timeline');


    Volt::route('timeline/{username}@{domain}', 'home.timeline.acct')
        ->name('home.timeline.acct');

    Volt::route('/{username}@{domain}', 'home.acct.index')
        ->name('home.acct.index');
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
