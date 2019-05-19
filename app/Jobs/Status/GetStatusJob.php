<?php

namespace App\Jobs\Status;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use GuzzleHttp\Psr7;

use Carbon\Carbon;

use App\Model\Account;
use App\Model\Reblog;
use App\Model\Tag;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;
use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

use Revolution\Mastodon\Facades\Mastodon;

class GetStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * Create a new job instance.
     *
     * @param  Account  $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Execute the job.
     *
     * @param  StatusRepository  $statusRepository
     * @param  AccountRepository  $accountRepository
     *
     * @return void
     */
    public function handle(StatusRepository $statusRepository, AccountRepository $accountRepository)
    {
        info('GetStatusesJob: '.$this->account->url);

        $this->statusRepository = $statusRepository;

        try {
            $this->account = $accountRepository->refresh($this->account);
        } catch (\Exception $e) {
            logger()->error('ClientException(refresh): '.$this->account->url.' '.$e->getMessage());

            $this->account->increment('fails');

            return;
        }

        try {
            $statuses = $this->get();

            $since_id = $this->since();
        } catch (\Exception $e) {
            logger()->error('ClientException: '.$this->account->url.' '.$e->getMessage());

            $this->account->increment('fails');

            return;
        }

        $this->account->fill(['fails' => 0])->save();

        $this->create($statuses);

        if (! empty($since_id)) {
            $accountRepository->updateSince($this->account, $since_id);
        }
    }

    /**
     * @param  array|null  $statuses
     */
    protected function create(?array $statuses)
    {
        foreach ($statuses as $status) {
            if (data_get($status, 'visibility') === 'direct') {
                continue;
            }

            $data = $this->status($status);

            if (empty($data['uri'])) {
                continue;
            }

            $this->newStatus($status, $data);
        }
    }

    /**
     * @param  array  $status
     *
     * @return array
     */
    protected function status(array $status): array
    {
        $data = Arr::only($status, [
            'id',
            'created_at',
            'content',
            'spoiler_text',
            'uri',
            'url',
        ]);

        $date = Carbon::parse($data['created_at'], 'UTC');

        $data['created_at'] = $date->toDateTimeString();

        $data = Arr::add($data, 'status_id', $data['id']);
        $data = Arr::add($data, 'account_id', $this->account->id);

        return $data;
    }

    /**
     * @param  array  $status
     * @param  array  $data
     */
    protected function newStatus(array $status, array $data)
    {
        $attr = [
            'uri'        => $data['uri'],
            'account_id' => $this->account->id,
        ];

        $new_status = $this->statusRepository->updateOrCreate($attr, $data);

        if (filled(data_get($status, 'reblog'))) {
            $reblog = $this->reblog(data_get($status, 'reblog'));
            $new_status->reblog()->associate($reblog)->save();
        }

        if (filled(data_get($status, 'tags'))) {
            $tags = $this->tag(data_get($status, 'tags'));
            $new_status->tags()->sync($tags);
        }
    }

    /**
     * @return array
     */
    protected function get()
    {
        return $this->account->mastodon()
                             ->statuses(
                                 $this->account->account_id,
                                 40,
                                 $this->account->since_id
                             );
    }

    /**
     * @return string|null
     */
    protected function since()
    {
        $since_id = null;

        $response = Mastodon::getResponse();

        if (! $response->hasHeader('Link')) {
            return null;
        }

        $link = Psr7\parse_header($response->getHeader('Link'));

        if (empty($link)) {
            return null;
        }

        $link = Arr::first($link, function ($value, $key) {
            return data_get($value, 'rel') === 'prev';
        });

        $link = head($link);

        $since_id = Str::before(Str::after($link, '&since_id='), '>');

        return $since_id;
    }

    /**
     * @param  array  $reblog
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function reblog(array $reblog)
    {
        $data = [
            'created_at'   => Carbon::parse($reblog['created_at'], 'UTC'),
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
     * @param  array  $tags
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

    /**
     * 失敗したジョブの処理
     *
     * @param  \Exception  $exception
     *
     * @return void
     */
    public function failed(\Exception $exception)
    {
        $this->account->increment('fails');
    }
}
