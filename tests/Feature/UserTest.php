<?php

namespace Tests\Feature;

use App\Livewire\StatusToggle;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Server $server;

    protected Account $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::first();

        $this->server = Server::first();

        $this->account = Account::factory()->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'username' => 'test',
            'display_name' => '<script>test',
            'note' => '<p></p>',
            'url' => 'https://example.com/@test',
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_welcome()
    {
        $response = $this->actingAs($this->user)
            ->get('/');

        $response->assertOk();
    }

    public function test_dont_see_welcome()
    {
        $response = $this->get('/');

        $response->assertDontSee('Home');
    }

    public function test_home()
    {
        $response = $this->actingAs($this->user)
            ->get('/home');

        $response->assertSee('Dashboard');
        $response->assertSee('Accounts');
    }

    public function test_home_redirect()
    {
        $response = $this->get('/home');

        $response->assertDontSee('Home');
        $response->assertRedirect('/login');
    }

    public function test_home_show()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
        ]);

        Livewire::test(StatusToggle::class, [
            'status' => $statuses,
        ])
            ->call('toggle');

        $response = $this->actingAs($this->user)
            ->get('/home');

        $response->assertSeeLivewire('status-toggle');
    }

    public function test_home_hide()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'deleted_at' => now(),
        ]);

        Livewire::test(StatusToggle::class, [
            'status' => $statuses,
        ])
            ->call('toggle');

        $response = $this->actingAs($this->user)
            ->get('/home');

        $response->assertSeeLivewire('status-toggle');
    }

    public function test_timeline()
    {
        $response = $this->actingAs($this->user)
            ->get('/home/timeline');

        $response->assertRedirect();
    }

    public function test_timeline_acct()
    {
        $response = $this->actingAs($this->user)
            ->get('/home/timeline/test@example.com');

        $response->assertSee('Timeline');
        $response->assertSee('<tt-user-timeline', false);
    }

    public function test_dont_see_timeline()
    {
        $response = $this->get('/home/timeline');

        $response->assertRedirect('/login');
    }

    public function test_timeline_another()
    {
        $user2 = User::factory()->create([
            'name' => 'test2',
        ]);

        $response = $this->actingAs($user2)
            ->get('/home/timeline/test@example.com');

        $response->assertStatus(403);
    }

    public function test_user()
    {
        $response = $this->actingAs($this->user)
            ->get('/@test');

        $response->assertSee('Accounts');
        $response->assertDontSee('Recents');
        $response->assertSee('Public area');
    }

    public function test_dont_see_user()
    {
        $response = $this->get('/@test2');

        $response->assertStatus(404);
    }

    public function test_account()
    {
        $response = $this->actingAs($this->user)
            ->get('/@test/test@example.com');

        $response->assertSee('Profile')
            ->assertSee('test@example.com')
            ->assertDontSee('<script>test', false);
    }

    public function test_account_another()
    {
        $response = $this->get('/@test/test@example.com');

        $response->assertSee('Profile');
        $response->assertSee('test@example.com');
    }

    public function test_locked_account()
    {
        $accounts = Account::factory()->create([
            'user_id' => (int) $this->user->id,
            'server_id' => $this->server->id,
            'username' => 'test2',
            'url' => 'https://example.com/@test2',
            'locked' => true,
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/test2@example.com');

        $response->assertStatus(200);
        $response->assertSee('Profile');
        $response->assertSee('test2@example.com');
    }

    public function test_locked_account_another()
    {
        $user2 = User::factory()->create([
            'name' => 'test2',
        ]);

        $accounts = Account::factory()->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'username' => 'test2',
            'url' => 'https://example.com/@test2',
            'locked' => true,
        ]);

        $response = $this->actingAs($user2)->get('/@test/test2@example.com');

        $response->assertStatus(403);
        //        $response->assertDontSee('Profile');
    }

    public function test_status()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'status_id' => 1,
            'content' => '<p>test</p>',
            'spoiler_text' => '<script>test',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/test@example.com/1');

        $response->assertSee($statuses->content, false)
            ->assertDontSee('<script>test', false);
    }

    public function test_locked_status_another()
    {
        $user2 = User::factory()->create();

        $account = Account::factory()->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'username' => 'test2',
            'url' => 'https://example.com/@test2',
            'locked' => true,
        ]);

        $statuses = Status::factory()->create([
            'account_id' => $account->id,
            'status_id' => 1,
        ]);

        $response = $this->actingAs($user2)
            ->get('/@test/test2@example.com/1');

        $response->assertStatus(403);
        //        $response->assertDontSee('Profile');
    }

    public function test_date()
    {
        Carbon::setTestNow(Carbon::parse('2017-04-24'));

        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/date/2017/04/24');

        $response->assertSee($statuses->content);
    }

    public function test_date_month()
    {
        Carbon::setTestNow(Carbon::parse('2017-04-24'));

        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/date/2017/04');

        $response->assertSee($statuses->content);
    }

    public function test_date_year()
    {
        Carbon::setTestNow(Carbon::parse('2017-04-24'));

        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/date/2017');

        $response->assertSee($statuses->content);
    }

    public function test_locked_date()
    {
        Carbon::setTestNow(Carbon::parse('2017-04-24'));

        $accounts = Account::factory()->create([
            'user_id' => $this->user->id,
            'locked' => true,
        ]);

        $statuses = Status::factory()->create([
            'account_id' => $accounts->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/date/2017-04-24');

        $response->assertDontSee($statuses->content);
    }

    public function test_date_redirect()
    {
        Carbon::setTestNow(Carbon::parse('2017-04-24'));

        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/date');

        $response->assertDontSee($statuses->content)
            ->assertRedirect('/@test');
    }

    public function test_sitemap()
    {
        $response = $this->get('/sitemaps');

        $response->assertStatus(200);
    }

    public function test_search_home()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'content' => 'test',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/home?search=test');

        $response->assertOk()
            ->assertSee('test');
    }

    public function test_search_home_empty()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'content' => '',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/home?search=test');

        $response->assertStatus(200);
        $response->assertDontSee('class="media"');
    }

    public function test_search_account()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'content' => 'test',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/test@example.com?search=test');

        $response->assertSee('test');
    }

    public function test_archives()
    {
        Carbon::setTestNow(Carbon::parse('2017-05-16'));

        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/archives');

        $response->assertSee('2017-05');
        $response->assertDontSee('2017-05-16');
    }
}
