<?php

namespace App\Jobs;

use App\Model\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Revolution\Mastodon\Facades\Mastodon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InstanceVersionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    protected $server;

    /**
     * Create a new job instance.
     *
     * @param  Server  $server
     *
     * @return void
     */
    public function __construct($server)
    {
        $this->server = $server;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        rescue(function () {
            $instance = Mastodon::domain($this->server->domain)->instance();

            $this->server->fill([
                'version'   => data_get($instance, 'version', ''),
                'streaming' => data_get($instance, 'urls.streaming_api', ''),
            ])->save();
        });
    }
}
