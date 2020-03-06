<?php

namespace Tests\Feature;

use App\Jobs\Status\GetStatusJob;
use App\Model\Account;
use App\Model\Server;
use App\Model\User;
use App\Repository\Account\EloquentAccountRepository as AccountRepository;
use App\Repository\Status\EloquentStatusRepository as StatusRepository;
use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class ArtisanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $this->server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);
    }

    public function testGetStatuses()
    {
        Bus::fake();

        $this->account = factory(Account::class, 5)->create([
            'user_id'   => $this->user->id,
            'server_id' => $this->server->id,
            'locked'    => false,
            //            'username'  => 'test',
            //            'url'       => 'https://example.com/@test',
        ]);

        Artisan::call('toot:statuses');

        Bus::assertDispatched(GetStatusJob::class);
    }

    public function testGetStatusesFails()
    {
        Bus::fake();

        $this->account = factory(Account::class, 5)->create([
            'user_id'   => $this->user->id,
            'server_id' => $this->server->id,
            'fails'    => 10,
            //            'username'  => 'test',
            //            'url'       => 'https://example.com/@test',
        ]);

        Artisan::call('toot:statuses');

        Bus::assertNotDispatched(GetStatusJob::class);
    }
}
