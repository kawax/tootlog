<?php

namespace App\Jobs\Status;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Cake\Chronos\Chronos;

use App\Model\Account;
use App\Model\Reblog;
use App\Model\Tag;

use App\Repository\Status\StatusRepositoryInterface as Status;
use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

use Revolution\Mastodon\Statuses;


class GetStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Account
     */
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

        try {
            $statuses = $mstdn->token($this->account->token)
                              ->get(
                                  $this->account->server->domain,
                                  $this->account->account_id,
                                  $this->account->since_id
                              );
        } catch (ClientException $e) {
            \Log::error('ClientException: ' . $this->account->url . ' ' . $e->getMessage());

            $this->account->increment('fails');

            return;
        }

        $this->account->fill(['fails' => 0])->save();

        //        dd($statuses);

        $since_id = null;

        foreach ($statuses as $status) {
            if ($status['visibility'] == 'direct') {
                continue;
            }

            $data = array_only($status, [
                'id',
                'created_at',
                'content',
                'spoiler_text',
                'uri',
                'url',
            ]);


            $date = Chronos::parse($data['created_at'], 'UTC');

            $data['created_at'] = $date->toDateTimeString();

            $data = array_add($data, 'status_id', $data['id']);
            $data = array_add($data, 'account_id', $this->account->id);

            //            array_pull($data, 'id');


            if (empty($data['uri'])) {
                continue;
            }

            if (!empty($status['reblog'])) {
                $reblog = $this->reblog($status['reblog']);
                //                $new_status->reblog()->associate($reblog)->save();
                $data = array_add($data, 'reblog_id', $reblog->id);
            }

            $attr = [
                'uri'        => $data['uri'],
                'account_id' => $this->account->id,
            ];

            $new_status = $statusRepository->updateOrCreate($attr, $data);


            if (!empty($status['tags'])) {
                //                \Log::info($status['tags']);
                $tags = $this->tags($status['tags']);
                $new_status->tags()->sync($tags);
            }

            if (empty($since_id)) {
                $since_id = $data['id'];
                $accountRepository->updateSince($this->account, $since_id);
            }
        }
    }

    /**
     * @param array $reblog
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function reblog(array $reblog)
    {
        $data = [
            'created_at'   => Chronos::parse($reblog['created_at'], 'UTC'),
            'status_id'    => $reblog['id'],
            'acct'         => $reblog['account']['acct'],
            'display_name' => $reblog['account']['display_name'],
            'account_url'  => $reblog['account']['url'],
            'avatar'       => $reblog['account']['avatar'],
            'content'      => $reblog['content'],
            'spoiler_text' => $reblog['spoiler_text'],
            'uri'          => $reblog['uri'],
            'url'          => $reblog['url'],
        ];

        $re = Reblog::updateOrCreate(['uri' => $reblog['uri']], $data);

        return $re;
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    protected function tags(array $tags)
    {
        $ids = [];

        foreach ($tags as $tag) {
            $ids[] = Tag::firstOrCreate(['name' => $tag['name']], $tag)->id;
        }

        return $ids;
    }
}
