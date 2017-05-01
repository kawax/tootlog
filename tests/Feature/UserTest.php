<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Model\User;
use App\Model\Server;
use App\Model\Account;
use App\Model\Status;
use Cake\Chronos\Chronos;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWelcome()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)
                         ->get('/');

        $response->assertSee('Home');
        $response->assertSee('Timeline');
    }

    public function testDontSeeWelcome()
    {
        $response = $this->get('/');

        $response->assertDontSee('Home');
    }

    public function testHome()
    {
        $user = factory(User::class)->make([
            'name' => 'test',
        ]);

        $response = $this->actingAs($user)
                         ->get('/home');

        $response->assertSee('Home');
        $response->assertSee('@test Account List');
    }

    public function testHomeRedirect()
    {
        $response = $this->get('/home');

        $response->assertDontSee('Home');
        $response->assertRedirect('/login');
    }

    public function testTimeline()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)
                         ->get('/timeline');

        $response->assertSee('Timeline');
    }

    public function testDontSeeTimeline()
    {
        $response = $this->get('/timeline');

        $response->assertRedirect('/login');
    }

    public function testUser()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $accounts = factory(Account::class, 5)->make([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
                         ->get('/@test');

        $response->assertSee('@test Account List');
        $response->assertSee('Recent');
        $response->assertViewHas('accounts');
    }

    public function testDontSeeUser()
    {
        $response = $this->get('/@test');

        $response->assertStatus(404);
    }

    public function testAccount()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => $user->id,
            'server_id' => $server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
        ]);

        $response = $this->actingAs($user)
                         ->get('/@test/test@example.com');

        $response->assertSee('Profile');
        $response->assertSee('test@example.com');
    }

    public function testAccountAnother()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => $user->id,
            'server_id' => $server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
        ]);

        $response = $this->get('/@test/test@example.com');

        $response->assertSee('Profile');
        $response->assertSee('test@example.com');
    }

    public function testLockedAccount()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => (int)$user->id,
            'server_id' => $server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
            'locked'    => true,
        ]);

        $response = $this->actingAs($user)
                         ->get('/@test/test@example.com');

        $response->assertStatus(200);
        $response->assertSee('Profile');
        $response->assertSee('test@example.com');
    }

    public function testLockedAccountAnother()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $user2 = factory(User::class)->create([
            'name' => 'test2',
        ]);

        $server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => $user->id,
            'server_id' => $server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
            'locked'    => true,
        ]);

        $response = $this->actingAs($user2)->get('/@test/test@example.com');

        $response->assertStatus(403);
        $response->assertDontSee('Profile');
    }

    public function testStatus()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => $user->id,
            'server_id' => $server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $accounts->id,
            'status_id'  => 1,
        ]);

        $response = $this->actingAs($user)
                         ->get('/@test/test@example.com/1');

        $response->assertSee($statuses->content);
    }

    public function testLockedStatusAnother()
    {
        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $user2 = factory(User::class)->create([
            'name' => 'test2',
        ]);

        $server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => $user->id,
            'server_id' => $server->id,
            'username'  => 'test',
            'url'       => 'https://example.com/@test',
            'locked'    => true,
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $accounts->id,
            'status_id'  => 1,
        ]);

        $response = $this->actingAs($user2)
                         ->get('/@test/test@example.com/1');

        $response->assertStatus(403);
        $response->assertDontSee('Profile');
    }

    public function testDate()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id' => $user->id,
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $accounts->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($user)
                         ->get('/@test/date/2017-04-24');

        $response->assertSee($statuses->content);
    }

    public function testLockedDate()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id' => $user->id,
            'locked'  => true,
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $accounts->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($user)
                         ->get('/@test/date/2017-04-24');

        $response->assertDontSee($statuses->content);
    }
}
