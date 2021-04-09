<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\Status\StatusRepository as Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * @param  User  $user
     * @param  Status  $statusRepository
     *
     * @return Application|Factory|View
     */
    public function index(User $user, Status $statusRepository)
    {
        $statuses = $statusRepository->openUserStatuses($user);

        return view('open.user')->with(compact('user', 'statuses'));
    }
}
