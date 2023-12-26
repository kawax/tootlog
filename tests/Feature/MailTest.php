<?php

namespace Tests\Feature;

use App\Jobs\Status\ExportCsvJob;
use App\Mail\Export\CsvExported;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MailTest extends TestCase
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

        $this->travelTo(Carbon::parse('2017-04-24'));

        $this->user = factory(User::class)->create([
            'name' => 'test',
        ]);

        $this->server = factory(Server::class)->create([
            'domain' => 'https://example.com',
        ]);

        $this->account = factory(Account::class)->create([
            'user_id' => $this->user->id,
            'server_id' => $this->server->id,
            'username' => 'test',
            'url' => 'https://example.com/@test',
        ]);

        $this->statuses = factory(Status::class, 10)->create([
            'account_id' => $this->account->id,
            'created_at' => now(),
        ]);
    }

    public function testExportJob()
    {
        Bus::fake();

        $response = $this->actingAs($this->user)
                         ->post('/export/csv');

        Bus::assertDispatched(ExportCsvJob::class);

        $response->assertSessionHas('export');
    }

    public function testExportMail()
    {
        Mail::fake();
        Storage::fake('local');

        $response = $this->actingAs($this->user)
                         ->post('/export/csv');

        $user = $this->user;

        Mail::assertQueued(CsvExported::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        Storage::disk('local')->assertExists('csv/test/test@example.com.csv');

        $response->assertSessionHas('export');
    }

    public function testDontSeeExport()
    {
        $response = $this->post('/export/csv');

        $response->assertRedirect('/login');
    }
}
