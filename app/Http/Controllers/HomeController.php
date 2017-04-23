<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repository\Account\AccountRepositoryInterface as Account;

class HomeController extends Controller
{
    /**
     * Redirect a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Account $account)
    {
        $accounts = $account->index();

//        dd($accounts);

        return view('home')->with(compact('accounts'));
    }
}
