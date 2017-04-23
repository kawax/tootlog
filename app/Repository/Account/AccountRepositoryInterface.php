<?php

namespace App\Repository\Account;

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
    public function userAccounts();


    /**
     * @param $user
     * @param $server
     *
     * @return mixed
     */
    public function store($user, $server);

}
