<?php

namespace App\Repository\Account;

use App\Model\Account;

interface AccountRepositoryInterface
{

    /**
     *
     * @return mixed
     */
    public function all();

    /**
     *
     * @return mixed
     */
    public function oldest();

    /**
     *
     * @return mixed
     */
    public function userAccounts();

    /**
     *
     * @return mixed
     */
    public function openAccounts($user);


    /**
     * @param Account $account
     *
     * @return mixed
     */
    public function refresh(Account $account);

    /**
     * @param Account $account
     *
     * @return mixed
     */
    public function updateSince(Account $account, $since_id);


    /**
     * @param $user
     * @param $server
     *
     * @return mixed
     */
    public function store($user, $server);

}
