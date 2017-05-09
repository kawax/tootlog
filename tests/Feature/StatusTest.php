<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;

use GuzzleHttp\Exception\ClientException;

use Cake\Chronos\Chronos;
use Faker\Factory as Faker;

use App\Model\User;
use App\Model\Server;
use App\Model\Account;
use App\Model\Status;

use App\Repository\Status\EloquentStatusRepository as StatusRepository;
use App\Repository\Account\EloquentAccountRepository as AccountRepository;

use App\Jobs\Status\GetStatusJob;

use Mastodon;

class StatusTest extends TestCase
{
    use DatabaseMigrations;

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

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $this->server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $this->account = factory(Account::class)->create([
            'user_id'   => $this->user->id,
            'server_id' => $this->server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
        ]);

        $this->statusRepository = m::mock(StatusRepository::class)->makePartial();

        $this->accountRepository = m::mock(AccountRepository::class)->makePartial();
    }

    public function testGetStatusJob()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make([
            'id'         => 1,
            'account_id' => $this->account->id,
            'visibility' => 'public',
            'created_at' => $faker->dateTime,
            'content'    => 'test',
        ]);

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('status_list')->once()->andReturn([$statuses->toArray()]);


        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas('statuses', [
            'account_id' => $this->account->id,
            'status_id'  => 1,
            'content'    => 'test',
        ]);
    }

    public function testGetStatusJobDirect()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make([
            'id'         => 1,
            'account_id' => $this->account->id,
            'visibility' => 'direct',
            'created_at' => $faker->dateTime,
            'content'    => 'test',
        ]);

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('status_list')->once()->andReturn([$statuses->toArray()]);


        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseMissing('statuses', [
            'account_id' => $this->account->id,
            'status_id'  => 1,
            'content'    => 'test',
        ]);
    }

    public function testGetStatusJobReblog()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make([
            'id'         => 1,
            'account_id' => $this->account->id,
            'visibility' => 'public',
            'created_at' => $faker->dateTime,
            'content'    => 'test',
            'reblog'     => [
                'id'           => 2,
                'created_at'   => Chronos::now()->toDateTimeString(),
                'account'      => [
                    'acct'         => $faker->userName,
                    'display_name' => $faker->name,
                    'url'          => $faker->url,
                    'avatar'       => $faker->imageUrl,
                ],
                'content'      => 'reblog_content',
                'spoiler_text' => 'spoiler_text',
                'uri'          => 'uri',
                'url'          => $faker->url,
            ],
        ]);

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('status_list')->once()->andReturn([$statuses->toArray()]);


        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas('reblogs', [
            'status_id'    => 2,
            'content'      => 'reblog_content',
            'spoiler_text' => 'spoiler_text',
        ]);

        $this->assertDatabaseHas('statuses', [
            'account_id' => $this->account->id,
            'status_id'  => 1,
            'reblog_id'  => 1,
        ]);
    }

    public function testGetStatusJobTag()
    {
        $job = new GetStatusJob($this->account);

        $faker = Faker::create();

        $statuses = factory(Status::class)->make([
            'id'         => 1,
            'account_id' => $this->account->id,
            'visibility' => 'public',
            'created_at' => $faker->dateTime,
            'content'    => 'test',
            'tags'       => [
                [
                    'name' => 'tag_test',
                ],
                [
                    'name' => 'tag_test2',
                ],
            ],
        ]);

        $this->accountRepository->shouldReceive('refresh')->with($this->account)->once()->andReturn($this->account);

        Mastodon::shouldReceive('domain')->with($this->server->domain)->once()->andReturn(m::self());
        Mastodon::shouldReceive('token')->once()->andReturn(m::self());
        Mastodon::shouldReceive('status_list')->once()->andReturn([$statuses->toArray()]);

        $job->handle($this->statusRepository, $this->accountRepository);


        $this->assertDatabaseHas('tags', [
            'name' => 'tag_test',
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'tag_test2',
        ]);

        $this->assertDatabaseHas('statuses', [
            'account_id' => $this->account->id,
            'status_id'  => 1,
        ]);
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
        Mastodon::shouldReceive('status_list')->once()->andThrow(m::mock(ClientException::class));

        $job->handle($this->statusRepository, $this->accountRepository);

        $this->assertDatabaseHas('accounts', [
            'fails' => 1,
        ]);
    }

}
