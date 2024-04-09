<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\Status\StatusRepository as Status;

class ArchiveController extends Controller
{
    public function __invoke(User $user, Status $statusRepository)
    {
        $archives = $statusRepository->openArchives($user);

        return view('open.archives')->with(compact('user', 'archives'));
    }
}
