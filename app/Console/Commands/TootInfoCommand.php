<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use Illuminate\Console\Command;
use Mastodon;

class TootInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post count info';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        info(self::class);

        $faces = collect([
            '😀',
            '😃',
            '😇',
            '😜',
            '😎',
            '🙄',
            '🤔',
            '😱',
            '🙃',
            '😶',
        ]);

        $status = [
            '🌐 '.Server::count('id').' instances',
            $faces->random().' '.Account::count('id').' accounts',
            '💬 '.Status::count('id').' statuses',
        ];

        Mastodon::domain(config('services.mastodon_notify.domain'))
                ->token(config('services.mastodon_notify.token'))
                ->createStatus(implode(PHP_EOL, $status));
    }
}
