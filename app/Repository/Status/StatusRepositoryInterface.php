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
     * ユーザーの日付別ステータス（公開用）
     *
     * @param User   $user
     * @param string $date
     *
     * @return mixed
     */
    public function openUserStatusesByDate(User $user, string $date);

    /**
     * ユーザーの最近のステータス（公開用）
     *
     * @param User $user
     *
     * @return mixed
     */
    public function openRecents(User $user);

    /**
     * アカウントのステータス（公開用）
     *
     * @param Account $acct
     *
     * @return mixed
     */
    public function openAcctStatuses(Account $acct);

    /**
     * アカウントのステータス（公開用）
     *
     * @param Account $acct
     * @param string  $status_id
     *
     * @return mixed
     */
    public function getByAcct(Account $acct, string $status_id);

    /**
     * ユーザーのカレンダー（公開）
     *
     * @param User $user
     *
     * @return mixed
     */
    public function openCalendar(User $user);

    /**
     * アカウントのカレンダー（公開）
     *
     * @param Account $acct
     *
     * @return mixed
     */
    public function openAcctCalendar(Account $acct);

    /**
     *
     * @param array $attr
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attr, array $values);

    /**
     * CSVエクスポート
     *
     * @param Account $account
     *
     * @return mixed
     */
    public function exportCsv(Account $account);

}
