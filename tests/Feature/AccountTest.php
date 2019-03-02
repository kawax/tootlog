<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Model\User;
use App\Model\Server;
use App\Model\Account;
use App\Model\Status;

use Carbon\Carbon;

class AccountTest extends TestCase
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

    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('2019-03-02'));

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
            'created_at' => now(),
        ]);
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
                         ->delete('/accounts/delete/1');

        $this->assertDatabaseMissing('accounts', [
            'id' => $this->account->id,
        ]);

        $response->assertRedirect('home')
                 ->assertSessionHas('message');
    }

    public function testDestroyAnother()
    {
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)
                         ->delete('/accounts/delete/1');

        $this->assertDatabaseHas('accounts', [
            'id' => $this->account->id,
        ]);

        $response->assertStatus(403);
    }
}
