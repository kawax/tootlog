<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\Status\StatusRepository as Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DateController extends Controller
{
    /**
     * AccountController constructor.
     *
     * @param  Status  $statusRepository
     */
    public function __construct(protected Status $statusRepository)
    {
    }

    /**
     * @param  User  $user
     * @param  string|null  $year
     * @param  string|null  $month
     * @param  string|null  $day
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function date(User $user, ?string $year = null, ?string $month = null, ?string $day = null)
    {
        if (empty($year)) {
            return redirect(route('open.user', $user));
        }

        $date = $year;

        if (! empty($month)) {
            $date .= '-'.$month;
        }

        if (! empty($day)) {
            $date .= '-'.$day;
        }

        $statuses = $this->statusRepository->openUserStatusesByDate($user, $year, $month, $day);

        return view('open.date')->with(compact('user', 'statuses', 'date'));
    }

    /**
     * @param  User  $user
     * @param  string  $date
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function show(User $user, string $date)
    {
        $year = explode('-', $date)[0];
        $month = explode('-', $date)[1];
        $day = explode('-', $date)[2];

        return redirect(route('open.user.date.day', [$user, $year, $month, $day]));
    }
}
