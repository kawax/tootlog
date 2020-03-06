<?php

namespace App\Jobs\Status;

use App\Mail\Export\CsvExported;
use App\Model\Account;
use App\Model\Status;
use App\Model\User;
use App\Repository\Status\StatusRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Storage;

class ExportCsvJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * @var Writer
     */
    protected $writer;

    /**
     * @var array
     */
    protected $files = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param  StatusRepository  $statusRepository
     *
     * @return void
     */
    public function handle(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;

        $accounts = $this->user->accounts;

        $accounts->each(function ($account) {
            $this->write($account);
        });

        \Mail::to($this->user)->send(new CsvExported($this->files));
    }

    /**
     * @param  Account  $account
     *
     * @return void
     */
    private function write(Account $account)
    {
        info('Export: '.$this->user->name.' / '.$account->acct);

        $this->writer = Writer::createFromFileObject(new \SplTempFileObject());

        $this->writer->insertOne($this->header());

        $statuses = $this->statusRepository->exportCsv($account);

        $statuses->chunk(1000, function ($chunk_statuses) {
            /**
             * @var Status $status
             */
            foreach ($chunk_statuses as $status) {
                $this->insert($status);
            }
        });

        $path = 'csv/'.$this->user->name.'/'.$account->acct.'.csv';

        if (Storage::put($path, $this->writer)) {
            $this->files[] = $path;
        }
    }

    /**
     * @return array
     */
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
     * @param  Status  $status
     */
    protected function insert(Status $status)
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
