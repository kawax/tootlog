<?php

namespace App\Repository\Status;

use App\Models\Account;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StatusRepository
{
    /**
     * ユーザーのステータス.
     *
     * @return LengthAwarePaginator
     */
    public function userStatuses();

    /**
     * ユーザーのステータス（公開用）.
     *
     * @param  User  $user
     *
     * @return LengthAwarePaginator
     */
    public function openUserStatuses(User $user);

    /**
     * ユーザーの日付別ステータス（公開用）.
     *
     * @param  User  $user
     * @param  string  $year
     * @param  string|null  $month
     * @param  string|null  $day
     *
     * @return LengthAwarePaginator
     */
    public function openUserStatusesByDate(User $user, string $year, ?string $month = null, ?string $day = null);

    /**
     * ユーザーの最近のステータス（公開用）.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function openRecents(User $user);

    /**
     * ユーザーのアーカイブス（公開用）.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function openArchives(User $user);

    /**
     * ユーザーのタグ別ステータス（公開用）.
     *
     * @param  User  $user
     * @param  Tag  $tag
     *
     * @return array
     */
    public function openUserTagStatus(User $user, Tag $tag);

    /**
     * アカウントのステータス（公開用）.
     *
     * @param  Account  $acct
     *
     * @return array
     */
    public function openAcctStatuses(Account $acct);

    /**
     * アカウントのステータス（公開用）.
     *
     * @param  Account  $acct
     * @param  string  $status_id
     *
     * @return mixed
     */
    public function getByAcct(Account $acct, string $status_id);

    /**
     * ユーザーのカレンダー（公開）.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function openCalendar(User $user);

    /**
     * アカウントのカレンダー（公開）.
     *
     * @param  Account  $acct
     *
     * @return mixed
     */
    public function openAcctCalendar(Account $acct);

    /**
     * @param  array  $attr
     * @param  array  $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attr, array $values);

    /**
     * CSVエクスポート.
     *
     * @param  Account  $account
     *
     * @return mixed
     */
    public function exportCsv(Account $account);
}
