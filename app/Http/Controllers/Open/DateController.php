<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

use App\Repository\Status\StatusRepositoryInterface as Status;

class DateController extends Controller
{
    /**
     * @var Status
     */
    protected $statusRepository;

    /**
     * AccountController constructor.
     *
     * @param Status  $statusRepository
     */
    public function __construct(Status $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function show(User $user, string $date)
    {
        $statuses = $this->statusRepository->openUserStatusesByDate($user, $date);

        return view('open.date')->with(compact('user',  'statuses', 'date'));

    }
}
