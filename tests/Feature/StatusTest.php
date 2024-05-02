<?php

namespace Tests\Feature;

use App\Jobs\Status\GetStatusJob;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use Faker\Factory as Faker;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery as m;
use Revolution\Mastodon\Facades\Mastodon;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Server $server;

    protected Account $account;

    protected Status $statuses;

    protected Response $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(
            [
                'name' => 'test',
            ],
        );

        $this->server = Server::factory()->create(
            [
                'domain' => 'https://example.com',
            ],
        );

        $this->account = Account::factory()->create(
            [
                'user_id' => $this->user->id,
                'server_id' => $this->server->id,
                'username' => 'test',
                'url' => 'https://example.com/@test',
            ],
        );

        $this->response = new Response(200, [], 'body');
    }

    public function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }

    public function testGetStatusJob()
    {
        $job = new GetStatusJob($this->account);

        $statuses = Status::factory()->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'public',
                'created_at' => fake()->dateTime,
                'content' => 'test',
            ],
        );

        Mastodon::shouldReceive('domain')->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('verifyCredentials')->andReturn([

        ]);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle();

        $this->assertDatabaseHas(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
                'content' => 'test',
            ],
        );
    }

    public function testGetStatusJobDirect()
    {
        $job = new GetStatusJob($this->account);

        $statuses = Status::factory()->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'direct',
                'created_at' => fake()->dateTime,
                'content' => 'test',
            ],
        );

        Mastodon::shouldReceive('domain')->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('verifyCredentials')->andReturn([

        ]);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle();

        $this->assertDatabaseMissing(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
                'content' => 'test',
            ],
        );
    }

    public function testGetStatusJobReblog()
    {
        $job = new GetStatusJob($this->account);

        $statuses = Status::factory()->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'public',
                'created_at' => fake()->dateTime,
                'content' => 'test',
                'reblog' => [
                    'id' => 2,
                    'created_at' => now()->toDateTimeString(),
                    'account' => [
                        'acct' => fake()->userName,
                        'display_name' => fake()->name,
                        'url' => fake()->url,
                        'avatar' => fake()->imageUrl,
                    ],
                    'content' => 'reblog_content',
                    'spoiler_text' => 'spoiler_text',
                    'uri' => 'uri',
                    'url' => fake()->url,
                ],
            ],
        );

        Mastodon::shouldReceive('domain')->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('verifyCredentials')->andReturn([

        ]);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle();

        $this->assertDatabaseHas(
            'reblogs',
            [
                'status_id' => 2,
                'content' => 'reblog_content',
                'spoiler_text' => 'spoiler_text',
            ],
        );

        $this->assertDatabaseHas(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
                'reblog_id' => 1,
            ],
        );
    }

    public function testGetStatusJobTag()
    {
        $job = new GetStatusJob($this->account);

        $statuses = Status::factory()->make(
            [
                'id' => 1,
                'account_id' => $this->account->id,
                'visibility' => 'public',
                'created_at' => fake()->dateTime,
                'content' => 'test',
                'tags' => [
                    [
                        'name' => 'tag_test',
                    ],
                    [
                        'name' => 'tag_test2',
                    ],
                ],
            ],
        );

        Mastodon::shouldReceive('domain')->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('verifyCredentials')->andReturn([

        ]);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andReturn([$statuses->toArray()]);
        Mastodon::shouldReceive('getResponse')->once()->andReturn($this->response);

        $job->handle();

        $this->assertDatabaseHas(
            'tags',
            [
                'name' => 'tag_test',
            ],
        );

        $this->assertDatabaseHas(
            'tags',
            [
                'name' => 'tag_test2',
            ],
        );

        $this->assertDatabaseHas(
            'statuses',
            [
                'account_id' => $this->account->id,
                'status_id' => 1,
            ],
        );
    }

    /**
     * @expectedException
     */
    public function testGetStatusJobException()
    {
        $job = new GetStatusJob($this->account);

        Mastodon::shouldReceive('domain')->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('verifyCredentials')->andReturn([

        ]);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('statuses')->once()->andThrow(m::mock(ClientException::class));

        $job->handle();

        $this->assertDatabaseHas(
            'accounts',
            [
                'fails' => 1,
            ],
        );
    }
}
