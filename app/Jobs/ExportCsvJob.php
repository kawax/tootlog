<?php

namespace App\Jobs;

use App\Mail\Export\CsvExported;
use App\Models\Account;
use App\Models\Status;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;

class ExportCsvJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Writer $writer;

    protected array $files = [];

    /**
     * Create a new job instance.
     */
    public function __construct(protected User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $accounts = $this->user->accounts;

        $accounts->each(fn ($account) => $this->write($account));

        Mail::to($this->user)->send(new CsvExported($this->files));
    }

    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    private function write(Account $account): void
    {
        info('Export: '.$this->user->name.' / '.$account->acct);

        $this->writer = Writer::createFromFileObject(new \SplTempFileObject);

        $this->writer->insertOne($this->header());

        $account->statuses()
            ->withTrashed()
            ->where('reblog_id', null)
            ->with('account')
            ->latest()
            ->lazy()
            ->each(function ($status) {
                $this->insert($status);
            });

        $path = 'csv/'.$this->user->name.'/'.$account->acct.'.csv';

        if (Storage::put($path, $this->writer)) {
            $this->files[] = $path;
        }
    }

    protected function header(): array
    {
        return [
            'id',
            'content',
            'spoiler_text',
            'created_at',
            'uri',
            'url',
        ];
    }

    /**
     * @throws Exception
     */
    protected function insert(Status $status): void
    {
        $status_line = $status->only([
            'status_id',
            'content',
            'spoiler_text',
            'created_at',
            'uri',
            'url',
        ]);

        try {
            $this->writer->insertOne($status_line);
        } catch (CannotInsertRecord $e) {
            logger()->error($e->getMessage());
        }
    }
}
