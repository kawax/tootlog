<?php

namespace App\Jobs;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Revolution\Mastodon\Facades\Mastodon;
use Throwable;

class InstanceVersionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  Server  $server
     * @return void
     */
    public function __construct(protected Server $server)
    {
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
                'version' => data_get($instance, 'version', ''),
                'streaming' => data_get($instance, 'urls.streaming_api', ''),
            ])->save();
        }, report: false);
    }
}
