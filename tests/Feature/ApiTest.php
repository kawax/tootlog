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

class ApiTest extends TestCase
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

    public function setUp()
    {
        parent::setUp();

        Chronos::setTestNow(Chronos::parse('2017-04-24'));

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

        $this->statuses = factory(Status::class, 10)->create([
            'account_id' => $this->account->id,
            'created_at' => Chronos::now(),
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHide()
    {
        $response = $this->actingAs($this->user)
                         ->json('DELETE', '/api/status/hide/' . $this->statuses->first()->id);

        $response->assertJson([
            'message' => 'ok',
        ]);
    }

    public function testHideUnauthenticated()
    {
        $response = $this->json('DELETE', '/api/status/hide/' . $this->statuses->first()->id);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Unauthenticated.',
                 ]);
    }

    public function testHideAnother()
    {
        $user2 = factory(User::class)->make([
            'name' => 'test2',
        ]);

        $response = $this->actingAs($user2)
                         ->json('DELETE', '/api/status/hide/' . $this->statuses->first()->id);

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $response = $this->actingAs($this->user)
                         ->json('PUT', '/api/status/show/' . $this->statuses->first()->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'ok',
                 ]);
    }

    public function testShowAnother()
    {
        $user2 = factory(User::class)->make([
            'name' => 'test2',
        ]);

        $response = $this->actingAs($user2)
                         ->json('PUT', '/api/status/show/' . $this->statuses->first()->id);

        $response->assertStatus(403);
    }

    public function testCalendar()
    {
        $response = $this->actingAs($this->user)
                         ->json('GET', '/api/calendar/test');

        $response->assertStatus(200)
                 ->assertJson([
                     '2017-04-24' => 10,
                 ]);
    }

    public function testCalendarLogout()
    {
        $response = $this->json('GET', '/api/calendar/test');

        $response->assertStatus(200)
                 ->assertJson([
                     '2017-04-24' => 10,
                 ]);
    }

    public function testCalendarAnother()
    {
        $user2 = factory(User::class)->make([
            'name' => 'test2',
        ]);

        $response = $this->actingAs($user2)
                         ->json('GET', '/api/calendar/test');

        $response->assertStatus(200);
    }

    public function testCalendarAcct()
    {
        $response = $this->actingAs($this->user)
                         ->json('GET', '/api/calendar/test/test@example.com');

        $response->assertStatus(200)
                 ->assertJson([
                     '2017-04-24' => 10,
                 ]);
    }

    public function testCalendarAcctAnother()
    {
        $user2 = factory(User::class)->make([
            'name' => 'test2',
        ]);

        $response = $this->actingAs($user2)
                         ->json('GET', '/api/calendar/test/test@example.com');

        $response->assertStatus(200);
    }
}
