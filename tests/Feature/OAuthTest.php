<?php

namespace Tests\Feature;

use App\Jobs\Status\GetStatusJob;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Bus;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery as m;
use Revolution\Mastodon\Facades\Mastodon;
use Revolution\Mastodon\MastodonClient;
use Tests\TestCase;

class OAuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Server $server;

    protected Account $account;

    protected Status $statuses;

    protected MastodonClient $mastodon;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'test',
        ]);

        $this->server = Server::factory()->create(
            [
                'domain' => 'https://example.com',
                'redirect_uri' => route('accounts.callback'),
            ],
        );

        $this->mastodon = m::mock(MastodonClient::class);

        $this->app->instance(
            MastodonClient::class,
            $this->mastodon,
        );
    }

    public function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }

    public function testAccountAddRedirect()
    {
        $response = $this->actingAs($this->user)
            ->post(route('accounts.add'), ['domain' => 'https://example.com']);

        $response->assertStatus(302)->assertSessionHas('mastodon_domain');
    }

    public function testAccountAddRedirectNewServer()
    {
        Mastodon::shouldReceive('domain')->once()->andReturn(m::self());
        Mastodon::shouldReceive('createApp')->andReturn([
            'id' => 1,
            'redirect_uri' => '',
            'client_id' => '',
            'client_secret' => '',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('accounts.add'), ['domain' => 'https://example.org']);

        //dd($response);
        $response->assertStatus(302)->assertSessionHas('mastodon_domain');
    }

    public function testAccountAddCallbackUpdate()
    {
        Bus::fake();

        Socialite::shouldReceive('driver')->once()->andReturn(m::self());
        Socialite::shouldReceive('user')->once()->andReturn(
            (new SocialiteUser())
                ->setRaw([
                    'url' => 'https://example.com/@test',
                ])->setToken('test'),
        );

        $account = Account::factory()->create([
            'user_id' => $this->user->id,
            'username' => 'test',
            'url' => 'https://example.com/@test',
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['mastodon_domain' => 'https://example.com'])
            ->get(route('accounts.callback'));

        Bus::assertDispatched(GetStatusJob::class);

        $response->assertRedirect('/home');
    }

    public function testAccountAddCallbackStore()
    {
        Bus::fake();

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
            ->get(route('accounts.callback'));

        Bus::assertDispatched(GetStatusJob::class);

        $this->assertDatabaseHas('accounts', [
            'username' => 'test',
            'url' => 'https://example.com/@test',
        ]);

        $response->assertRedirect('/home');
    }
}
