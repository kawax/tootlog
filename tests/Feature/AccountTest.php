<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Server $server;

    protected Account $account;

    protected Collection $statuses;

    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('2019-03-02'));

        $this->user = User::first();

        $this->server = Server::first();

        $this->account = Account::factory()->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'username' => 'test',
            'url' => 'https://example.com/@test',
        ]);

        $this->statuses = Status::factory(10)->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('accounts.delete', $this->account));

        $this->assertDatabaseMissing('accounts', [
            'id' => $this->account->id,
        ]);

        $response->assertRedirect('home')
            ->assertSessionHas('message');
    }

    public function testDestroyAnother()
    {
        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)
            ->delete(route('accounts.delete', $this->account));

        $this->assertDatabaseHas('accounts', [
            'id' => $this->account->id,
        ]);

        $response->assertStatus(403);
    }
}
