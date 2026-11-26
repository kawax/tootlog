<?php

namespace App\Console\Commands;

use App\Jobs\CreateDownloadCsvJob;
use App\Models\Account;
use Illuminate\Console\Command;

class CreateCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:create-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CSV for download';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // アクティブ・非アクティブ含め全アカウントのCSVを作成。

        //        Account::query()
        //            ->each(function (Account $account) {
        //                CreateDownloadCsvJob::dispatch($account);
        //            });

        // 削除開始したのでCSV作成は停止。今日までのログはアーカイブとしてダウンロード可能。
        $this->error('CSV作成は停止しました。');

        return 0;
    }
}
