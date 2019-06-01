<?php

namespace App\Presenter;

use App\Model\Tag;

trait UserPresenter
{
    /**
     * @return mixed
     */
    public function tags()
    {
        return cache()->remember('user.tags/'.$this->id, now()->addMinutes(60), function () {
            $status_id = $this->statuses()
                              ->where('accounts.locked', false)
                              ->pluck('statuses.id');

            $tag_id = \DB::table('status_tag')
                         ->whereIn('status_id', $status_id)
                         ->pluck('tag_id')
                         ->unique()
                         ->toArray();

            return Tag::withCount('statuses')
                      ->orderBy('statuses_count', 'desc')
                      ->find($tag_id);
        });
    }
}
