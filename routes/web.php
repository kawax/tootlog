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
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

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

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
});

Route::get('instances', InstanceController::class)->name('instances');

Route::get('sitemaps', SitemapController::class);

Route::view('/', 'welcome')->name('welcome');

Route::view('usage', 'pages.usage')->name('usage.jp');

Route::view('en/usage', 'pages.en.usage')->name('usage.en');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

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

require __DIR__.'/open.php';
