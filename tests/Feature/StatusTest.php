<?php

namespace Tests\Feature;

use App\Jobs\Status\GetStatusJob;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use App\Repository\Account\EloquentAccountRepository as AccountRepository;
use App\Repository\Status\EloquentStatusRepository as StatusRepository;
use Faker\Factory as Faker;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mastodon;
use Mockery as m;
use Tests\TestCase;

class StatusTest extends TestCase
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
     * @var Status
     */
    protected $statuses;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @var Response
     */
    protected $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(
            [
                'name' => 'test',
            ]
        );

        $this->server = factory(Server::class)->create(
            [
                'domain' => 'https://example.com',
            ]
        );

        $this->account = factory(Account::class)->create(
            [
                'user_id' => $this->user->id,
                'server_id' => $this->server->id,
                'username' => 'test',
                'url' => 'https://example.com/@test',
            ]
        );

        $this->response = new Response(200, [], 'body');

        $this->statusRepository = m::mock(StatusRepository::class)->makePartial();

        $this->accountRepository = m::mock(AccountRepository::class)->makePartial();
    }

    public function tearDown(): void
    {
        m::close();
    }

    public function testGetStatusJob()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'public',
                'created_at' => $faker->dateTime,
                'content' => 'test',
            ]
        );

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
                'content' => 'test',
            ]
        );
    }

    public function testGetStatusJobDirect()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'direct',
                'created_at' => $faker->dateTime,
                'content' => 'test',
            ]
        );

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseMissing(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
                'content' => 'test',
            ]
        );
    }

    public function testGetStatusJobReblog()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'public',
                'created_at' => $faker->dateTime,
                'content' => 'test',
                'reblog' => [
                    'id' => 2,
                    'created_at' => now()->toDateTimeString(),
                    'account' => [
                        'acct' => $faker->userName,
                        'display_name' => $faker->name,
                        'url' => $faker->url,
                        'avatar' => $faker->imageUrl,
                    ],
                    'content' => 'reblog_content',
                    'spoiler_text' => 'spoiler_text',
                    'uri' => 'uri',
                    'url' => $faker->url,
                ],
            ]
        );

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas(
            'reblogs',
            [
                'status_id' => 2,
                'content' => 'reblog_content',
                'spoiler_text' => 'spoiler_text',
            ]
        );

        $this->assertDatabaseHas(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
                'reblog_id' => 1,
            ]
        );
    }

    public function testGetStatusJobTag()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'public',
                'created_at' => $faker->dateTime,
                'content' => 'test',
                'tags' => [
                    [
                        'name' => 'tag_test',
                    ],
                    [
                        'name' => 'tag_test2',
                    ],
                ],
            ]
        );

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas(
            'tags',
            [
                'name' => 'tag_test',
            ]
        );

        $this->assertDatabaseHas(
            'tags',
            [
                'name' => 'tag_test2',
            ]
        );

        $this->assertDatabaseHas(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
            ]
        );
    }

    /**
     * @expectedException
     */
    public function testGetStatusJobException()
    {
        $job = new GetStatusJob($this->account);

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andThrow(m::mock(ClientException::class));

        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas(
            'accounts',
            [
                'fails' => 1,
            ]
        );
    }
}
