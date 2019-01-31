<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Repository\Server\ServerRepositoryInterface as ServerRepository;
use Revolution\Mastodon\Facades\Mastodon;

class InstanceVersionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param ServerRepository $repository
     *
     * @return void
     */
    public function handle(ServerRepository $repository)
    {
        $repository->all()->each(function ($server) {
            rescue(function () use ($server) {
                $instance = Mastodon::domain($server->domain)->instance();

                $server->fill([
                    'version'   => data_get($instance, 'version', ''),
                    'streaming' => data_get($instance, 'urls.streaming_api', ''),
                ])->save();
            });
        });
    }
}
