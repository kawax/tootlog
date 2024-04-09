<?php

use App\Http\Controllers\Open\AccountController;
use App\Http\Controllers\Open\ArchiveController;
use App\Http\Controllers\Open\DateController;
use App\Http\Controllers\Open\TagController;
use App\Http\Controllers\Open\UserController;
use Illuminate\Support\Facades\Route;

Route::name('open.user')
    ->get('@{user}')
    ->uses([UserController::class, 'index']);

Route::name('open.account.index')
    ->get('@{user}/{username}@{domain}')
    ->uses([AccountController::class, 'index']);

Route::name('open.account.show')
    ->get('@{user}/{username}@{domain}/{status_id}')
    ->uses([AccountController::class, 'show']);

Route::name('open.user.date')
    ->get('@{user}/date/{date}')
    ->uses([DateController::class, 'show'])
    ->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');

Route::name('open.user.date.day')
    ->get('@{user}/date/{year?}/{month?}/{day?}')
    ->uses([DateController::class, 'date'])
    ->where('year', '[0-9]{4}')
    ->where('month', '[0-9]{2}')
    ->where('day', '[0-9]{2}');

Route::resource('@{user}/tags', TagController::class, ['only' => ['index', 'show']]);

Route::name('open.archives')
    ->get('@{user}/archives')
    ->uses(ArchiveController::class);
