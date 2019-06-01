<?php

namespace App\Repository\Server;

use Illuminate\Database\Query\Builder;
use App\Model\Server;

interface ServerRepository
{
    /**
     * @param  string  $domain
     *
     * @return mixed
     */
    public function get(string $domain);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * @param  string  $domain
     *
     * @return bool
     */
    public function has(string $domain): bool;

    /**
     * @param  array  $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param  string  $domain
     *
     * @return array
     */
    public function firstOrCreate(string $domain): array;

    /**
     * @param  int  $page
     *
     * @return mixed
     */
    public function instanceList(int $page = 10);
}
