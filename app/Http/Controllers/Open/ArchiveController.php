<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\Status\StatusRepository as Status;

class ArchiveController extends Controller
{
    /**
     * AccountController constructor.
     *
     * @param  Status  $statusRepository
     */
    public function __construct(protected Status $statusRepository)
    {
    }

    public function __invoke(User $user)
    {
        $archives = $this->statusRepository->openArchives($user);

        return view('open.archives')->with(compact('user', 'archives'));
    }
}
