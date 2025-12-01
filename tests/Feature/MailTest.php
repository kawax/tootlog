<?php

namespace Tests\Feature;

use App\Jobs\ExportCsvJob;
use App\Mail\Export\CsvExported;
use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Server $server;

    protected Account $account;

    protected Collection $statuses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2017-04-24'));

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
}
