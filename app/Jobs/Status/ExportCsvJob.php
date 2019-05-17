<?php

namespace App\Jobs\Status;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Storage;

use League\Csv\Writer;
use League\Csv\CannotInsertRecord;

use App\Model\User;
use App\Model\Status;
use App\Model\Account;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;

use App\Mail\Export\CsvExported;

class ExportCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        $accounts->each(function ($account, $key) {
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

        $header = [
            'id',
            'content',
            'spoiler_text',
            'created_at',
            'uri',
            'url',
        ];

        $this->writer->insertOne($header);

        $statuses = $this->statusRepository->exportCsv($account);

        $statuses->chunk(1000, function ($chunk_statuses) {
            /**
             * @var Status $status
             */
            foreach ($chunk_statuses as $status) {
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
        });

        $path = 'csv/'.$this->user->name.'/'.$account->acct.'.csv';

        if (Storage::put($path, $this->writer)) {
            $this->files[] = $path;
        }
    }
}
