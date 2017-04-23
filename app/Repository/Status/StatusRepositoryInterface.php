<?php

namespace App\Repository\Status;

interface StatusRepositoryInterface
{

    /**
     *
     * @return mixed
     */
    public function userStatuses();


    /**
     *
     * @param array $attr
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attr, array $values);

}
