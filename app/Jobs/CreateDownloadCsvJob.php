<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\Status;
use App\Models\User;
use App\Notifications\FailedCreateCsv;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;
use Throwable;

class CreateDownloadCsvJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 600;

    protected Writer $writer;

    protected array $files = [];

    /**
     * Create a new job instance.
     */
    public function __construct(protected Account $account) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->write($this->account);
    }

    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    private function write(Account $account): void
    {
        // 後でダウンロードする用のCSVを事前に作成。

        info('Create CSV for download: '.$account->acct);

        if ($account->statuses()->count() === 0) {
            return;
        }

        $this->writer = Writer::from(new \SplTempFileObject);
        $this->writer->setEscape('');

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

        $path = 'download/'.$this->account->user->name.'/'.$account->acct.'.csv';

        Storage::put($path, $this->writer);
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

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        $error = $this->account->acct.': '.$exception->getMessage();

        logger()->error($error);

        // ログが多すぎる場合は失敗する可能性があるので管理者宛に通知して確認。
        User::find(1)->notify(new FailedCreateCsv($error));
    }
}
