<?php

namespace App\Models\Concerns;

use App\Models\StatusTag;
use App\Models\Tag;

trait WithUserTag
{
    public function tags()
    {
        return cache()->remember('user.tags/'.$this->id, now()->addHours(12), function () {
            $status_id = $this->statuses()
                ->where('accounts.locked', false)
                ->pluck('statuses.id');

            $tag_id = StatusTag::whereIn('status_id', $status_id)
                ->pluck('tag_id')
                ->unique()
                ->toArray();

            return Tag::withCount('statuses')
                ->orderBy('statuses_count', 'desc')
                ->find($tag_id);
        });
    }
}
