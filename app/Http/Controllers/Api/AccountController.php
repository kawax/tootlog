<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Account\AccountRepositoryInterface as Account;

class AccountController extends Controller
{
    public function index(Account $accountRepository)
    {
        $accounts = $accountRepository->userAccounts();

        return $accounts;
    }

}
