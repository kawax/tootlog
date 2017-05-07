<?php

namespace Revolution\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Statuses
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * Apps constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $domain
     * @param int    $account_id
     * @param int    $since_id
     *
     * @return array
     */
    public function get(string $domain, int $account_id, int $since_id = null): array
    {
        //$since_id
        $url = $domain . "/api/v1/accounts/$account_id/statuses?limit=40&since_id=$since_id";
        $response = $this->client->get($url, [
            'headers' =>
                ['Authorization' => 'Bearer ' . $this->token],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $domain
     * @param int    $status_id
     *
     * @return array
     */
    public function get_status(string $domain, int $status_id): array
    {
        $url = $domain . "/api/v1/statuses/$status_id";
        $response = $this->client->get($url, [
            'headers' =>
                ['Authorization' => 'Bearer ' . $this->token],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function token(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param ClientInterface $client
     *
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }
}
