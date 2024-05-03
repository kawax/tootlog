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

    public function setUp(): void
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
    public function testWelcome()
    {
        $response = $this->actingAs($this->user)
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
        $response = $this->actingAs($this->user)
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

    public function testHomeShow()
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

    public function testHomeHide()
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

    public function testTimeline()
    {
        $response = $this->actingAs($this->user)
            ->get('/timeline');

        $response->assertSee('Timeline');
        $response->assertSee('<tt-user-timeline', false);
    }

    public function testTimelineAcct()
    {
        $response = $this->actingAs($this->user)
            ->get('/timeline/test@example.com');

        $response->assertSee('Timeline');
        $response->assertSee('<tt-user-timeline', false);
    }

    public function testDontSeeTimeline()
    {
        $response = $this->get('/timeline');

        $response->assertRedirect('/login');
    }

    public function testTimelineAnother()
    {
        $user2 = User::factory()->create([
            'name' => 'test2',
        ]);

        $response = $this->actingAs($user2)
            ->get('/timeline/test@example.com');

        $response->assertStatus(403);
    }

    public function testUser()
    {
        $response = $this->actingAs($this->user)
            ->get('/@test');

        $response->assertSee('@test Account List');
        $response->assertSee('Recent');
        $response->assertViewHas('statuses');
    }

    public function testDontSeeUser()
    {
        $response = $this->get('/@test2');

        $response->assertStatus(404);
    }

    public function testAccount()
    {
        $response = $this->actingAs($this->user)
            ->get('/@test/test@example.com');

        $response->assertSee('Profile')
            ->assertSee('test@example.com')
            ->assertDontSee('<script>test', false);
    }

    public function testAccountAnother()
    {
        $response = $this->get('/@test/test@example.com');

        $response->assertSee('Profile');
        $response->assertSee('test@example.com');
    }

    public function testLockedAccount()
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

    public function testLockedAccountAnother()
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

    public function testStatus()
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

    public function testLockedStatusAnother()
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

    public function testDate()
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

    public function testDateMonth()
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

    public function testDateYear()
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

    public function testLockedDate()
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

    public function testDateRedirect()
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

    public function testSitemap()
    {
        $response = $this->get('/sitemaps');

        $response->assertStatus(200);
    }

    public function testPreferences()
    {
        $response = $this->actingAs($this->user)
            ->get('/preferences');

        $response->assertSee('User Preferences');
    }

    public function testDontSeePreferences()
    {
        $response = $this->get('/preferences');

        $response->assertRedirect('/login');
    }

    public function testUpdatePreferences()
    {
        $response = $this->actingAs($this->user)
            ->put('/preferences', [
                'email' => 'test@example.com',
                'theme' => 'normal',
                'special_ley' => 'test',
            ]);

        $response->assertSuccessful()
            ->assertSee('User Preferences');
    }

    public function testUpdatePreferencesFail()
    {
        $response = $this->actingAs($this->user)
            ->put('/preferences', [
                'email' => 'test@example.com',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['theme']);
    }

    public function testSearchHome()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'content' => 'test',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/home?search=test');

        $response->assertViewHas('statuses');
    }

    public function testSearchHomeEmpty()
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

    public function testSearchAccount()
    {
        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'content' => 'test',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/test@example.com?search=test');

        $response->assertViewHas('statuses');
    }

    public function testUserTags()
    {
        $statuses = Status::factory()
            ->hasTags(1)
            ->create([
                'account_id' => $this->account->id,
            ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/tags');

        $response->assertViewHas('tags');
        $response->assertSee($statuses->tags()->first()->name);
    }

    public function testTag()
    {
        $statuses = Status::factory()
            ->hasTags(1, [
                'name' => 'test',
            ])
            ->create([
                'account_id' => $this->account->id,
                'content' => 'test',
            ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/tags/test?search=test');

        $response->assertViewHas('tag');
        $response->assertSee($statuses->content);
    }

    public function testLockedTag()
    {
        $accounts = Account::factory()->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'locked' => true,
        ]);

        $statuses = Status::factory()
            ->hasTags(1, [
                'name' => 'test',
            ])->create([
                'account_id' => $accounts->id,
            ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/tags/test');

        $response->assertDontSee($statuses->content);
    }

    public function testArchives()
    {
        Carbon::setTestNow(Carbon::parse('2017-05-16'));

        $statuses = Status::factory()->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/@test/archives');

        $response->assertSee('2017-05');
        $response->assertSee('2017-05-16');
    }
}
