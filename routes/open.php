<?php

use App\Http\Controllers\Open\AccountController;
use App\Http\Controllers\Open\ArchiveController;
use App\Http\Controllers\Open\DateController;
use App\Http\Controllers\Open\TagController;
use App\Http\Controllers\Open\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('@{user}', 'open.user')
    // ->uses([UserController::class, 'index'])
    ->name('open.user');

Volt::route('@{user}/{username}@{domain}', 'open.acct.index')
    ->name('open.account.index');

Volt::route('@{user}/{username}@{domain}/{status_id}', 'open.acct.show')
    ->name('open.account.show');

Route::get('@{user}/date/{date}')
    ->uses([DateController::class, 'show'])
    ->name('open.user.date')
    ->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');

Volt::route('@{user}/date/{year?}/{month?}/{day?}', 'open.date')
    // ->uses([DateController::class, 'date'])
    ->name('open.user.date.day')
    ->where('year', '[0-9]{4}')
    ->where('month', '[0-9]{2}')
    ->where('day', '[0-9]{2}');

Route::resource('@{user}/tags', TagController::class)
    ->only(['index', 'show']);

Volt::route('@{user}/archives', 'open.archives')
    ->name('open.archives');
