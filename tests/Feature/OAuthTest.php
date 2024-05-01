<?php

namespace Tests\Feature;

use App\Jobs\Status\GetStatusJob;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use App\Repository\Server\EloquentServerRepository as ServerRepository;
use App\Repository\Status\EloquentStatusRepository as StatusRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Bus;
use Mockery as m;
use Revolution\Mastodon\MastodonClient;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class OAuthTest extends TestCase
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
     * @var MastodonClient
     */
    protected $mastodon;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * @var ServerRepository
     */
    protected $serverRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $this->mastodon = m::mock(MastodonClient::class);

        $this->app->instance(
            \Revolution\Mastodon\MastodonClient::class,
            $this->mastodon,
        );

        $this->serverRepository = m::mock(ServerRepository::class)->makePartial();

        $this->app->instance(
            \App\Repository\Server\ServerRepository::class,
            $this->serverRepository,
        );
    }

    public function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }

    public function testAccountAddRedirect()
    {
        $this->serverRepository->shouldReceive('firstOrCreate')
            ->with('https://example.com')
            ->once()
            ->andReturn(['client_id' => '', 'client_secret' => '']);

        $response = $this->actingAs($this->user)
            ->post('/accounts', ['domain' => 'https://example.com']);

        $response->assertStatus(302)->assertSessionHas('mastodon_domain');
    }

    public function testAccountAddCallbackUpdate()
    {
        Bus::fake();

        $this->serverRepository->shouldReceive('firstOrCreate')
            ->with('https://example.com')
            ->once()
            ->andReturn(['client_id' => '', 'client_secret' => '']);

        Socialite::shouldReceive('driver')->once()->andReturn(m::self());
        Socialite::shouldReceive('user')->once()->andReturn(
            (new SocialiteUser())
                ->setRaw([
                    'url' => 'https://example.com/@test',
                ])->setToken('test'),
        );

        $account = factory(Account::class)->create([
            'user_id' => $this->user->id,
            'username' => 'test',
            'url' => 'https://example.com/@test',
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['mastodon_domain' => 'https://example.com'])
            ->get('/accounts/callback');

        Bus::assertDispatched(GetStatusJob::class);

        $response->assertRedirect('/home');
    }

    public function testAccountAddCallbackStore()
    {
        Bus::fake();

        $this->serverRepository->shouldReceive('firstOrCreate')
            ->with('https://example.com')
            ->once()
            ->andReturn(['id' => 1, 'client_id' => '', 'client_secret' => '']);

        Socialite::shouldReceive('driver')->once()->andReturn(m::self());
        Socialite::shouldReceive('user')->once()->andReturn(
            (new SocialiteUser())
                ->setRaw([
                    'id' => '1',
                    'url' => 'https://example.com/@test',
                    'username' => 'test',
                    'acct' => 'test',
                    'display_name' => 'test',
                    'locked' => '0',
                    'statuses_count' => '0',
                    'following_count' => '0',
                    'followers_count' => '0',
                    'note' => 'note',
                    'avatar' => '',
                    'avatar_static' => '',
                    'header' => '',
                    'header_static' => '',
                    'created_at' => '2017-05-01 00:00:00',
                ])->setToken('test'),
        );

        $response = $this->actingAs($this->user)
            ->withSession(['mastodon_domain' => 'https://example.com'])
            ->get('/accounts/callback');

        Bus::assertDispatched(GetStatusJob::class);

        $this->assertDatabaseHas('accounts', [
            'username' => 'test',
            'url' => 'https://example.com/@test',
        ]);

        $response->assertRedirect('/home');
    }
}
