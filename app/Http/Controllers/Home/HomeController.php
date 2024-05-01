<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repository\Status\StatusRepository as Status;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function __invoke(Request $request, Status $status)
    {
        $user = $request->user();

        $accounts = $user->allAccounts();
        $statuses = $status->userStatuses();

        return view('home')->with(compact('user', 'accounts', 'statuses'));
    }
}
