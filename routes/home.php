<?php

use Illuminate\Support\Facades\Route;
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
