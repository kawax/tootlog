<?php

namespace App\Console\Commands;

use App\Jobs\InstanceVersionJob;
use App\Models\Server;
use App\Repository\Server\ServerRepository;
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
     * @param  ServerRepository  $repository
     * @return mixed
     */
    public function handle(ServerRepository $repository)
    {
        $repository->all()->each(function (Server $server) {
            if ($server->accounts()->where('fails', '<', 10)->exists()) {
                InstanceVersionJob::dispatch($server);
            }
        });
    }
}
