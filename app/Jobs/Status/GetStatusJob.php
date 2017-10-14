<?php

namespace App\Jobs\Status;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Psr7;

use Cake\Chronos\Chronos;

use App\Model\Account;
use App\Model\Reblog;
use App\Model\Tag;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;
use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

use Mastodon;

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
     * @param StatusRepository  $statusRepository
     * @param AccountRepository $accountRepository
     *
     * @return void
     */
    public function handle(StatusRepository $statusRepository, AccountRepository $accountRepository)
    {
        info('GetStatusesJob: ' . $this->account->url);

        try {
            $this->account = $accountRepository->refresh($this->account);
        } catch (\Exception $e) {
            logger()->error('ClientException(refresh): ' . $this->account->url . ' ' . $e->getMessage());

            $this->account->increment('fails');

            return;
        }

        try {
            $statuses = $this->get();

            $since_id = $this->since();
        } catch (\Exception $e) {
            logger()->error('ClientException: ' . $this->account->url . ' ' . $e->getMessage());

            $this->account->increment('fails');

            return;
        }

        $this->account->fill(['fails' => 0])->save();

        //        dd($statuses);

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

            if (empty($data['uri'])) {
                continue;
            }

            $attr = [
                'uri'        => $data['uri'],
                'account_id' => $this->account->id,
            ];

            $new_status = $statusRepository->updateOrCreate($attr, $data);

            if (!empty($status['reblog'])) {
                $reblog = $this->reblog($status['reblog']);
                $new_status->reblog()->associate($reblog)->save();
            }

            if (!empty($status['tags'])) {
                $tags = $this->tag($status['tags']);
                $new_status->tags()->sync($tags);
            }
        }

        if (!empty($since_id)) {
            $accountRepository->updateSince($this->account, $since_id);
        }
    }

    /**
     * @return array
     */
    public function get()
    {
        return Mastodon::domain($this->account->server->domain)
                       ->token($this->account->token)
                       ->statuses(
                           $this->account->account_id,
                           40,
                           $this->account->since_id
                       );
    }

    /**
     * @return null|string
     */
    public function since()
    {
        $since_id = null;

        $response = Mastodon::getResponse();

        if ($response->hasHeader('Link')) {
            $link = Psr7\parse_header($response->getHeader('Link'));

            if (!empty($link)) {
                $link = array_first($link, function ($value, $key) {
                    return array_get($value, 'rel') === 'prev';
                });
                $link = head($link);

                $since_id = str_before(str_after($link, '&since_id='), '>');
            }
        }

        return $since_id;
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
    protected function tag(array $tags)
    {
        $ids = [];

        foreach ($tags as $tag) {
            $ids[] = Tag::firstOrCreate(['name' => $tag['name']], $tag)->id;
        }

        return $ids;
    }
}
