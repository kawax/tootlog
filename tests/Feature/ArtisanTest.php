<?php

namespace Tests\Feature;

use App\Jobs\GetStatusJob;
use App\Models\Account;
use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class ArtisanTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Server $server;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::first();

        $this->server = Server::first();
    }

    public function test_get_statuses()
    {
        Bus::fake();

        $account = Account::factory(5)->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'locked' => false,
            //            'username'  => 'test',
            //            'url'       => 'https://example.com/@test',
        ]);

        Artisan::call('toot:statuses');

        Bus::assertDispatched(GetStatusJob::class);
    }

    public function test_get_statuses_fails()
    {
        Bus::fake();

        $account = Account::factory(5)->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'fails' => 10,
            //            'username'  => 'test',
            //            'url'       => 'https://example.com/@test',
        ]);

        Artisan::call('toot:statuses');

        Bus::assertNotDispatched(GetStatusJob::class);
    }
}
