<?php

use Illuminate\Support\Facades\Route;

/**
 * Public Routes
 */
Route::livewire('@{user}', 'pages::open.user')
    ->name('open.user');

Route::livewire('@{user}/{username}@{domain}', 'pages::open.acct.index')
    ->name('open.account.index');

Route::livewire('@{user}/{username}@{domain}/{status_id}', 'pages::open.acct.show')
    ->name('open.account.show');

Route::livewire('@{user}/date/{year?}/{month?}/{day?}', 'pages::open.date')
    ->name('open.user.date.day')
    ->where('year', '[0-9]{4}')
    ->where('month', '[0-9]{2}')
    ->where('day', '[0-9]{2}');

Route::livewire('@{user}/archives', 'pages::open.archives')
    ->name('open.archives');
