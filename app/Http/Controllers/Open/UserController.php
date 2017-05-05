<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Status\StatusRepositoryInterface as Status;

class UserController extends Controller
{
    public function index(User $user, Status $statusRepository)
    {
        $statuses = $statusRepository->openUserStatuses($user);

        return view('open.user')->with(compact('user',  'statuses'));
    }
}
