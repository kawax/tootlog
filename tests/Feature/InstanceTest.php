<?php

namespace Tests\Feature;

use App\Jobs\InstanceVersionJob;
use App\Models\Account;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Revolution\Mastodon\Facades\Mastodon;
use Tests\TestCase;

class InstanceTest extends TestCase
{
    use RefreshDatabase;

    public function testHttp()
    {
        $server = Server::factory()->create();

        $response = $this->get(route('instances'));

        $response->assertSuccessful()
                 ->assertViewHas('instances');
    }

    public function testJob()
    {
        $server = Server::factory()->create();

        $job = new InstanceVersionJob($server);

        Mastodon::shouldReceive('domain')->andReturnSelf();
        Mastodon::shouldReceive('instance')->andReturn([
            'version' => 1,
            'urls' => [
                'streaming_api' => 'url',
            ],
        ]);

        $job->handle();

        $this->assertDatabaseHas('servers', [
            'version' => 1,
            'streaming' => 'url',
        ]);
    }

    public function testCommand()
    {
        Bus::fake();

        $server = Server::factory()->create();

        $account = Account::factory()->create([
            'server_id' => $server->id,
        ]);

        $this->artisan('toot:version')
             ->assertExitCode(0);

        Bus::assertDispatched(InstanceVersionJob::class);
    }
}
