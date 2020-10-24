<?php

use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Home\AccountController;
use App\Http\Controllers\Home\AccountDeleteController;
use App\Http\Controllers\Home\ExportController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PreferencesController;
use App\Http\Controllers\Home\TimelineController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now redirect something great!
|
*/

Route::middleware(['auth'])->group(
    function () {
        Route::name('accounts.add')->post('accounts')
             ->uses([AccountController::class, 'redirect']);

        Route::get('accounts/callback')
             ->uses([AccountController::class, 'callback']);

        Route::name('accounts.delete')
             ->delete('accounts/delete/{id}')
             ->uses(AccountDeleteController::class);

        Route::name('timeline')
             ->get('timeline')
             ->uses([TimelineController::class, 'index']);

        Route::name('timeline.account')
             ->get('timeline/{username}@{domain}')
             ->uses([TimelineController::class, 'acct']);

        Route::name('preferences.index')
             ->get('preferences')
             ->uses([PreferencesController::class, 'index']);

        Route::name('preferences.update')
             ->post('preferences')
             ->uses([PreferencesController::class, 'update']);

        Route::name('export.csv')
             ->post('export/csv')
             ->uses([ExportController::class, 'csv']);

        Route::name('home')
             ->get('home')
             ->uses([HomeController::class, 'index']);
    }
);

Route::middleware('auth')->prefix('api')->group(
    function () {
        Route::delete('status/hide/{status}')
             ->uses([StatusController::class, 'hide']);
        Route::put('status/show/{status}')
             ->uses([StatusController::class, 'show']);
    }
);

Route::prefix('api')->group(
    function () {
        Route::get('calendar/{user}')
             ->uses([CalendarController::class, 'index']);
        Route::get('calendar/{user}/{username}@{domain}')
             ->uses([CalendarController::class, 'acct']);
    }
);

Route::name('instances')
     ->get('instances')
     ->uses(InstanceController::class);

Route::get('sitemaps')
     ->uses(SitemapController::class);

Route::get('logs')
     ->uses([LogViewerController::class, 'index'])
     ->middleware('can:admin-logs');

Route::name('welcome')
     ->get('/')
     ->uses(WelcomeController::class);

Route::view('usage', 'pages.usage');
