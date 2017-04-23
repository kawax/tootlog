<?php

namespace App\Repository\Status;

use App\Model\Status;
use Cake\Chronos\Chronos;

class EloquentStatusRepository implements StatusRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function userStatuses()
    {
        $statuses = request()->user()
                             ->statuses()
                             ->with(['account', 'reblog'])
                             ->latest('created_at')
                             ->paginate(10);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(array $attr, array $values)
    {
        $status = Status::updateOrCreate($attr, $values);

        return $status;
    }
}
