<?php

namespace App\Repository\Server;

use Illuminate\Database\Query\Builder;
use App\Model\Server;

interface ServerRepositoryInterface
{
    /**
     * @param string $domain
     *
     * @return array
     */
    public function get(string $domain);

    /**
     * @param string $domain
     *
     * @return bool
     */
    public function has(string $domain): bool;

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param string $domain
     *
     * @return mixed
     */
    public function firstOrCreate(string $domain);
}
