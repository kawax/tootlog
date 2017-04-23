<?php

namespace App\Repository\Account;

use App\Model\Account;
use Cake\Chronos\Chronos;

class EloquentAccountRepository implements AccountRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all()
    {
        $accounts = Account::all();

        return $accounts;
    }

    /**
     * @inheritDoc
     */
    public function userAccounts()
    {
        $accounts = request()->user()
                             ->accounts()
            //                             ->with('server')
                             ->withCount('statuses')
                             ->get();

        return $accounts;
    }

    public function store($user, $server)
    {
        $data = $user->user;

        $data['account_id'] = $data['id'];
        $data['account_created_at'] = Chronos::parse($data['created_at']);
        $data['token'] = $user->token;
        $data['server_id'] = $server->id;

        $cond = array_only($data, ['account_id', 'username', 'server_id']);

        $account = request()->user()
                            ->accounts()
                            ->updateOrCreate($cond, $data);

        return $account;
    }

}
