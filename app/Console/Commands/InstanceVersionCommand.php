<?php

namespace App\Console\Commands;

use App\Jobs\InstanceVersionJob;
use App\Models\Server;
use Illuminate\Console\Command;

class InstanceVersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Server::all()->each(function (Server $server) {
            if ($server->accounts()->where('fails', '<', 10)->exists()) {
                InstanceVersionJob::dispatch($server);
            }
        });

        return 0;
    }
}
