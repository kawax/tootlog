<?php

namespace App\Repository\Account;

interface AccountRepositoryInterface
{

    /**
     *
     * @return mixed
     */
    public function index();


    /**
     * @param $user
     * @param $server
     *
     * @return mixed
     */
    public function store($user, $server);

}
