<?php

use App\Http\Controllers\Open\AccountController;
use App\Http\Controllers\Open\ArchiveController;
use App\Http\Controllers\Open\DateController;
use App\Http\Controllers\Open\TagController;
use App\Http\Controllers\Open\UserController;
use Illuminate\Support\Facades\Route;

Route::get('@{user}')
    ->uses([UserController::class, 'index'])
    ->name('open.user');

Route::get('@{user}/{username}@{domain}')
    ->uses([AccountController::class, 'index'])
    ->name('open.account.index');

Route::get('@{user}/{username}@{domain}/{status_id}')
    ->uses([AccountController::class, 'show'])
    ->name('open.account.show');

Route::get('@{user}/date/{date}')
    ->uses([DateController::class, 'show'])
    ->name('open.user.date')
    ->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');

Route::get('@{user}/date/{year?}/{month?}/{day?}')
    ->uses([DateController::class, 'date'])
    ->name('open.user.date.day')
    ->where('year', '[0-9]{4}')
    ->where('month', '[0-9]{2}')
    ->where('day', '[0-9]{2}');

Route::resource('@{user}/tags', TagController::class)
    ->only(['index', 'show']);

Route::get('@{user}/archives', ArchiveController::class)
    ->name('open.archives');
