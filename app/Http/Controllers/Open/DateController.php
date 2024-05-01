<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;

class DateController extends Controller
{
    public function date(User $user, ?string $year = null, ?string $month = null, ?string $day = null)
    {
        if (empty($year)) {
            return to_route('open.user', $user);
        }

        $date = Carbon::create($year, $month, $day)->toDateString();

        $statuses = $user->openStatusesByDate($year, $month, $day)->simplePaginate();

        return view('open.date')->with(compact('user', 'statuses', 'date'));
    }

    /**
     * YYYY-MM-DD形式を現在のURLにリダイレクト.
     */
    public function show(User $user, string $date)
    {
        $year = explode('-', $date)[0];
        $month = explode('-', $date)[1];
        $day = explode('-', $date)[2];

        return to_route('open.user.date.day', [$user, $year, $month, $day]);
    }
}
