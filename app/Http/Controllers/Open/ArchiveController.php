<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Repository\Status\StatusRepository as Status;

class ArchiveController extends Controller
{
    /**
     * @var Status
     */
    protected $statusRepository;

    /**
     * AccountController constructor.
     *
     * @param  Status  $statusRepository
     */
    public function __construct(Status $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function __invoke(User $user)
    {
        $archives = $this->statusRepository->openArchives($user);

        return view('open.archives')->with(compact('user', 'archives'));
    }
}
