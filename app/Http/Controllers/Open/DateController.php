<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;

class DateController extends Controller
{
    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * AccountController constructor.
     *
     * @param StatusRepository $statusRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * @param User   $user
     * @param string $date
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(User $user, string $date)
    {
        $year = explode('-', $date)[0];
        $month = explode('-', $date)[1];
        $day = explode('-', $date)[2];

        return redirect(route('open.user.date.day', [$user, $year, $month, $day]));
    }

    /**
     * @param User   $user
     * @param string $year
     * @param string $month
     * @param string $day
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function date(User $user, string $year = null, string $month = null, string $day = null)
    {
        if (empty($year)) {
            return redirect(route('open.user', $user));
        }

        $date = $year;

        if (!empty($month)) {
            $date .= '-' . $month;
        }

        if (!empty($day)) {
            $date .= '-' . $day;
        }

        $statuses = $this->statusRepository->openUserStatusesByDate($user, $year, $month, $day);

        return view('open.date')->with(compact('user', 'statuses', 'date'));
    }
}
