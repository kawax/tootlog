<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\Reblog;
use App\Models\Status;
use App\Models\Tag;
use App\Support\Header;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Revolution\Mastodon\Facades\Mastodon;

class GetStatusJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Account $account)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('GetStatusesJob: '.$this->account->url);

        try {
            $this->account = $this->refresh($this->account);
        } catch (Exception $exception) {
            logger()->error('ClientException(refresh): '.$this->account->url.' '.$exception->getMessage());

            $this->account->increment('fails');

            return;
        }

        try {
            $statuses = $this->get();

            $since_id = $this->since();
        } catch (Exception $exception) {
            logger()->error('ClientException: '.$this->account->url.' '.$exception->getMessage());

            $this->account->increment('fails');

            return;
        }

        $this->account->fill(['fails' => 0])->save();

        $this->create($statuses);

        if (! empty($since_id)) {
            $this->account->fill(['since_id' => $since_id])->save();
        }
    }

    protected function refresh(Account $account): Account
    {
        $data = Mastodon::domain($account->server->domain)
            ->token($account->token)
            ->verifyCredentials();

        $account->fill($data)->save();

        return $account;
    }

    protected function create(?array $statuses): void
    {
        foreach ($statuses as $status) {
            $this->createStatus($status);
        }
    }

    protected function createStatus(?array $status): void
    {
        if (data_get($status, 'visibility') === 'direct') {
            return;
        }

        $data = $this->statusData($status);

        if (empty($data['uri'])) {
            return;
        }

        DB::transaction(function () use ($status, $data) {
            $this->newStatus($status, $data);
        });
    }

    protected function statusData(array $status): array
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

        return Arr::add($data, 'account_id', $this->account->id);
    }

    protected function newStatus(array $status, array $data): void
    {
        $attr = [
            'uri' => $data['uri'],
            'account_id' => $this->account->id,
        ];

        $new_status = Status::withTrashed()->updateOrCreate($attr, $data);

        if (filled(data_get($status, 'reblog'))) {
            $reblog = $this->reblog(data_get($status, 'reblog'));
            $new_status->reblog()->associate($reblog)->save();
        }

        if (filled(data_get($status, 'tags'))) {
            $tags = $this->tag(data_get($status, 'tags'));
            $new_status->tags()->sync($tags);
        }
    }

    protected function get(): array
    {
        return $this->account->mastodon()
            ->statuses(
                account_id: $this->account->account_id,
                limit: 40,
                since_id: $this->account->since_id,
            );
    }

    protected function since(): ?string
    {
        $response = Mastodon::getResponse();

        return Header::since($response);
    }

    protected function reblog(array $reblog): Reblog
    {
        $data = [
            'created_at' => Carbon::parse($reblog['created_at'], 'UTC'),
            'status_id' => $reblog['id'],
            'acct' => $reblog['account']['acct'],
            'display_name' => $reblog['account']['display_name'],
            'account_url' => $reblog['account']['url'],
            'avatar' => $reblog['account']['avatar'],
            'content' => $reblog['content'],
            'spoiler_text' => $reblog['spoiler_text'],
            'uri' => $reblog['uri'],
            'url' => $reblog['url'],
        ];

        return Reblog::updateOrCreate(['uri' => $reblog['uri']], $data);
    }

    protected function tag(array $tags): array
    {
        $ids = [];

        foreach ($tags as $tag) {
            $ids[] = Tag::firstOrCreate(['name' => $tag['name']], $tag)->id;
        }

        return $ids;
    }

    public function failed(): void
    {
        $this->account->increment('fails');
    }
}
