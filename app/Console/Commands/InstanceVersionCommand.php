<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Repository\Server\ServerRepositoryInterface as ServerRepository;
use App\Jobs\InstanceVersionJob;

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
     * @param ServerRepository $repository
     *
     * @return mixed
     */
    public function handle(ServerRepository $repository)
    {
        $repository->all()->each(function ($server) {
            InstanceVersionJob::dispatch($server);
        });
    }
}
