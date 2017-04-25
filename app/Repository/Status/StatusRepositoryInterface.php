<?php

namespace App\Repository\Status;

use App\Model\User;
use App\Model\Account;


interface StatusRepositoryInterface
{

    /**
     * ユーザーのステータス
     *
     * @return mixed
     */
    public function userStatuses();


    /**
     * ユーザーのステータス（公開用）
     *
     * @param User $user
     *
     * @return mixed
     */
    public function openUserStatuses(User $user);

    /**
     * アカウントのステータス（公開用）
     *
     * @param Account $acct
     *
     * @return mixed
     */
    public function openAcctStatuses(Account $acct);


    /**
     *
     * @param array $attr
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attr, array $values);

}
