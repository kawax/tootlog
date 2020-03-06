<?php

namespace Tests\Feature;

use App\Model\Account;
use App\Model\Server;
use App\Model\Status;
use App\Model\Tag;
use App\Model\User;
use Cake\Chronos\Chronos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
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

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $this->server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $this->account = factory(Account::class)->create([
            'user_id'      => $this->user->id,
            'server_id'    => $this->server->id,
            'username'     => 'test',
            'display_name' => '<script>test',
            'note'         => '<p></p>',
            'url'          => 'https://example.com/@test',
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
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/home');

        $response->assertSee('<tt-status-toggle checked status');
    }

    public function testHomeHide()
    {
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'deleted_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/home');

        $response->assertSee('<tt-status-toggle status');
    }

    public function testTimeline()
    {
        $response = $this->actingAs($this->user)
                         ->get('/timeline');

        $response->assertSee('Timeline');
        $response->assertSee('<tt-user-timeline');
    }

    public function testTimelineAcct()
    {
        $response = $this->actingAs($this->user)
                         ->get('/timeline/test@example.com');

        $response->assertSee('Timeline');
        $response->assertSee('<tt-user-timeline');
    }

    public function testDontSeeTimeline()
    {
        $response = $this->get('/timeline');

        $response->assertRedirect('/login');
    }

    public function testTimelineAnother()
    {
        $user2 = factory(User::class)->create([
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

    public function testUserCalender()
    {
        $response = $this->actingAs($this->user)
                         ->get('/@test');

        $response->assertSee('<tt-calendar user="test"></tt-calendar>');
    }

    public function testAccount()
    {
        $response = $this->actingAs($this->user)
                         ->get('/@test/test@example.com');

        $response->assertSee('Profile')
                 ->assertSee('test@example.com')
                 ->assertDontSee('<script>test');
    }

    public function testAccountAnother()
    {
        $response = $this->get('/@test/test@example.com');

        $response->assertSee('Profile');
        $response->assertSee('test@example.com');
    }

    public function testLockedAccount()
    {
        $accounts = factory(Account::class)->create([
            'user_id'   => (int) $this->user->id,
            'server_id' => $this->server->id,
            'username'  => 'test2',
            'url'       => 'https://example.com/@test2',
            'locked'    => true,
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/test2@example.com');

        $response->assertStatus(200);
        $response->assertSee('Profile');
        $response->assertSee('test2@example.com');
    }

    public function testLockedAccountAnother()
    {
        $user2 = factory(User::class)->create([
            'name' => 'test2',
        ]);

        $accounts = factory(Account::class)->create([
            'user_id'   => $this->user->id,
            'server_id' => $this->server->id,
            'username'  => 'test2',
            'url'       => 'https://example.com/@test2',
            'locked'    => true,
        ]);

        $response = $this->actingAs($user2)->get('/@test/test2@example.com');

        $response->assertStatus(403);
        //        $response->assertDontSee('Profile');
    }

    public function testStatus()
    {
        $statuses = factory(Status::class)->create([
            'account_id'   => $this->account->id,
            'status_id'    => 1,
            'content'      => '<p>test</p>',
            'spoiler_text' => '<script>test',
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/test@example.com/1');

        $response->assertSee($statuses->content)
                 ->assertDontSee('<script>test');
    }

    public function testLockedStatusAnother()
    {
        $user2 = factory(User::class)->create();

        $account = factory(Account::class)->create([
            'user_id'   => $this->user->id,
            'server_id' => $this->server->id,
            'username'  => 'test2',
            'url'       => 'https://example.com/@test2',
            'locked'    => true,
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $account->id,
            'status_id'  => 1,
        ]);

        $response = $this->actingAs($user2)
                         ->get('/@test/test2@example.com/1');

        $response->assertStatus(403);
        //        $response->assertDontSee('Profile');
    }

    public function testDate()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/date/2017/04/24');

        $response->assertSee($statuses->content);
    }

    public function testDateMonth()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/date/2017/04');

        $response->assertSee($statuses->content);
    }

    public function testDateYear()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/date/2017');

        $response->assertSee($statuses->content);
    }

    public function testLockedDate()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $accounts = factory(Account::class)->create([
            'user_id' => $this->user->id,
            'locked'  => true,
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $accounts->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/date/2017-04-24');

        $response->assertDontSee($statuses->content);
    }

    public function testDateRedirect()
    {
        Chronos::setTestNow(Chronos::parse('2017-04-24'));

        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'created_at' => Chronos::now(),
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
                         ->post('/preferences', [
                             'email'       => 'test@example.com',
                             'theme'       => 'normal',
                             'special_ley' => 'test',
                         ]);

        $response->assertSuccessful()
                 ->assertSee('User Preferences');
    }

    public function testUpdatePreferencesFail()
    {
        $response = $this->actingAs($this->user)
                         ->post('/preferences', [
                             'email' => 'test@example.com',
                         ]);

        $response->assertStatus(302)
                 ->assertSessionHasErrors(['theme']);
    }

    public function testSearchHome()
    {
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'content'    => 'test',
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/home?search=test');

        $response->assertViewHas('statuses');
    }

    public function testSearchHomeEmpty()
    {
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'content'    => '',
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/home?search=test');

        $response->assertStatus(200);
        $response->assertDontSee('class="media"');
    }

    public function testSearchAccount()
    {
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'content'    => 'test',
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/test@example.com?search=test');

        $response->assertViewHas('statuses');
    }

    public function testUserTags()
    {
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
        ]);

        $tag = factory(Tag::class)->create([
            'name' => 'test_tag',
        ]);

        \DB::table('status_tag')->insert(['status_id' => $statuses->id, 'tag_id' => $tag->id]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/tags');

        $response->assertViewHas('tags');
        $response->assertSee('test_tag');
    }

    public function testTag()
    {
        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'content'    => 'test',
        ]);

        $tag = factory(Tag::class)->create([
            'name' => 'test',
        ]);

        \DB::table('status_tag')->insert(['status_id' => $statuses->id, 'tag_id' => $tag->id]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/tags/test?search=test');

        $response->assertViewHas('tag');
        $response->assertSee($statuses->content);
    }

    public function testLockedTag()
    {
        $accounts = factory(Account::class)->create([
            'user_id' => $this->user->id,
            'locked'  => true,
        ]);

        $statuses = factory(Status::class)->create([
            'account_id' => $accounts->id,
        ]);

        $tag = factory(Tag::class)->create([
            'name' => 'test',
        ]);

        \DB::table('status_tag')->insert(['status_id' => $statuses->id, 'tag_id' => $tag->id]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/tags/test');

        $response->assertDontSee($statuses->content);
    }

    public function testArchives()
    {
        Chronos::setTestNow(Chronos::parse('2017-05-16'));

        $statuses = factory(Status::class)->create([
            'account_id' => $this->account->id,
            'created_at' => Chronos::now(),
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/@test/archives');

        $response->assertSee('2017-05');
        $response->assertSee('2017-05-16');
    }
}
