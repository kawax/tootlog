<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified'])->prefix('home')->group(function () {
    Volt::route('/', 'home.home')
        ->name('home');

    Volt::route('/{username}@{domain}', 'home.acct.index')
        ->name('home.acct.index');
});
