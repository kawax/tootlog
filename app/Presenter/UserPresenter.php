<?php

namespace App\Presenter;

use App\Model\Tag;

trait UserPresenter
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function tags()
    {
        $tags = cache()->remember('user.tags/' . $this->id, 60, function () {
            $status_id = $this->statuses()
                              ->where('accounts.locked', false)
                              ->pluck('statuses.id');

            $tag_id = \DB::table('status_tag')
                         ->whereIn('status_id', $status_id)
                         ->pluck('tag_id')
                         ->unique()
                         ->toArray();

            $tags = Tag::withCount('statuses')
                       ->orderBy('statuses_count', 'desc')
                       ->find($tag_id);

            return $tags;
        });

        return $tags;
    }
}
