<?php

namespace App\Jobs\Status;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Cake\Chronos\Chronos;

use App\Model\Account;
use App\Model\Reblog;
use App\Repository\Status\StatusRepositoryInterface as Status;
use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

use Revolution\Mastodon\Statuses;


class GetStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $account;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Execute the job.
     *
     * @param Statuses          $mstdn
     * @param Status            $statusRepository
     * @param AccountRepository $accountRepository
     *
     * @return void
     */
    public function handle(Statuses $mstdn, Status $statusRepository, AccountRepository $accountRepository)
    {
        \Log::info('GetStatusesJob: ' . $this->account->url);

        $this->account = $accountRepository->refresh($this->account);

//        $this->account->touch();

        $statuses = $mstdn->token($this->account->token)
                          ->get(
                              $this->account->server->domain,
                              $this->account->account_id,
                              $this->account->since_id
                          );

//                dd($statuses);

        $since_id = null;

        foreach ($statuses as $status) {
            $data = array_only($status, [
                'id',
                'created_at',
                'content',
                'uri',
            ]);

            if(empty($since_id)){
                $since_id = $data['id'];
                $accountRepository->updateSince($this->account, $since_id);
            }

            $date = Chronos::parse($data['created_at'], 'UTC');

            $data['created_at'] = $date->toDateTimeString();

            $data = array_add($data, 'status_id', $data['id']);
            $data = array_add($data, 'account_id', $this->account->id);

            array_pull($data, 'id');

            if (!empty($status['reblog'])) {
                $reblog = $status['reblog'];
                $reb = $this->reblog($reblog);
                $data = array_add($data, 'reblog_id', $reb->id);
            }

            if (!empty($data['uri'])) {
                $sta = $statusRepository->updateOrCreate(['uri' => $data['uri']], $data);
            }
        }
    }

    protected function reblog($reblog)
    {
        $data = [
            'created_at'   => Chronos::parse($reblog['created_at'], 'UTC'),
            'status_id'    => $reblog['id'],
            'acct'         => $reblog['account']['acct'],
            'display_name' => $reblog['account']['display_name'],
            'account_url'  => $reblog['account']['url'],
            'avatar'       => $reblog['account']['avatar'],
            'content'      => $reblog['content'],
            'uri'          => $reblog['uri'],
            'url'          => $reblog['url'],
        ];

        $re = Reblog::firstOrCreate($data);

        return $re;
    }
}
