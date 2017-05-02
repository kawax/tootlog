<?php

namespace App\Jobs\Status;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Storage;
use Laracsv\Export;

use App\Model\User;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;

use App\Mail\Export\CsvExported;

class ExportCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

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

            $export = new Export();

            $export->build($statuses, [
                'status_id' => 'id',
                'content',
                'spoiler_text',
                'created_at',
                'uri',
                'url',
            ]);

            $path = 'csv/' . $this->user->name . '/' . $account->acct . '.csv';
            $files[] = $path;

            Storage::put($path, (string)$export->getCsv());
        });


        \Mail::to($this->user)->send(new CsvExported($files));
    }
}

