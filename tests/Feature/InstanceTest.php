<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

use App\Jobs\InstanceVersionJob;
use App\Model\Server;

use Revolution\Mastodon\Facades\Mastodon;

class InstanceTest extends TestCase
{
    use RefreshDatabase;

    public function testHttp()
    {
        $server = factory(Server::class)->create();

        $response = $this->get(route('instances'));

        $response->assertSuccessful()
                 ->assertViewHas('instances');
    }

    public function testJob()
    {
        $server = factory(Server::class)->create();

        $job = new InstanceVersionJob($server);

        Mastodon::shouldReceive('domain->instance')->andReturn([
            'version' => 1,
            'urls'    => [
                'streaming_api' => 'url',
            ],
        ]);

        $job->handle();

        $this->assertDatabaseHas('servers', [
            'version'   => 1,
            'streaming' => 'url',
        ]);
    }

    public function testCommand()
    {
        Bus::fake();

        $server = factory(Server::class)->create();

        $this->artisan('toot:version')
             ->assertExitCode(0);

        Bus::assertDispatched(InstanceVersionJob::class);
    }
}
