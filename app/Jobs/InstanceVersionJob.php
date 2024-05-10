<?php

namespace App\Jobs;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Revolution\Mastodon\Facades\Mastodon;

class InstanceVersionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Server $server)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        rescue(function () {
            $instance = Mastodon::domain($this->server->domain)->apiVersion('v2')->instance();

            $this->server->fill([
                'version' => data_get($instance, 'version', ''),
                'streaming' => data_get($instance, 'configuration.urls.streaming', ''),
            ])->save();
        }, report: false);
    }
}
