<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $accounts = $user->allAccounts();
        $statuses = $user->allStatuses($request->query('search'))->paginate();

        return view('home')->with(compact('user', 'accounts', 'statuses'));
    }
}
