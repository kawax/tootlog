<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Mail\Export\CsvExported;
use App\Jobs\Status\ExportCsvJob;

use App\Model\User;
use App\Model\Server;
use App\Model\Account;
use App\Model\Status;
use Cake\Chronos\Chronos;

class MailTest extends TestCase
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

    public function testExportJob()
    {
        Bus::fake();

        $response = $this->actingAs($this->user)
                         ->post('/export/csv');

        $user = $this->user;

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

        Mail::assertSent(CsvExported::class, function ($mail) use ($user) {
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
