<?php

namespace App\Jobs\Status;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Storage;
use League\Csv\Writer;

use App\Model\User;
use App\Model\Status;

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
     * @var Writer
     */
    protected $writer;

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
     * @param StatusRepository $statusRepository
     *
     * @return void
     */
    public function handle(StatusRepository $statusRepository)
    {
        $accounts = $this->user->accounts;

        $files = [];

        $accounts = $accounts->each(function ($account, $key) use ($statusRepository, &$files) {
            \Log::info('Export: ' . $account->acct);

            $statuses = $statusRepository->exportCsv($account);

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

            $statuses->chunk(1000, function ($chunk_statuses) {
                /**
                 * @var Status $status
                 */
                foreach ($chunk_statuses as $status) {
                    $status_line = array_only($status->toArray(), [
                        'status_id',
                        'content',
                        'spoiler_text',
                        'created_at',
                        'uri',
                        'url',
                    ]);

                    $this->writer->insertOne($status_line);
                }
            });

            $path = 'csv/' . $this->user->name . '/' . $account->acct . '.csv';
            $files[] = $path;

            Storage::put($path, (string)$this->writer);
        });


        \Mail::to($this->user)->send(new CsvExported($files));
    }
}
