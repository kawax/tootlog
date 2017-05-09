<?php

namespace App\Console\Commands\Status;

use Illuminate\Console\Command;

use App\Model\Status;
use App\Model\Reblog;

use Mastodon;

class ReblogMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:reblog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reblog maintenance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * reblog情報の保存に失敗しているステータスを修正する。
     *
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $statuses = Status::where('content', '<p></p>')
                          ->whereNull('reblog_id')->get();

        \Log::info('Reblog maintenance: ' . $statuses->count());

        foreach ($statuses as $status) {
            $new_status = Mastodon::domain($status->account->server->domain)
                                  ->token($status->account->token)
                                  ->status_get($status->status_id);

            if (!empty($new_status['reblog'])) {
                $uri = $new_status['reblog']['uri'];
                //                \Log::info('Reblog maintenance: ' . $uri);

                $reblog = Reblog::where('uri', $uri)->first();
                if ($reblog) {
                    $status->reblog()->associate($reblog)->save();
                }
            }
        }
    }
}
