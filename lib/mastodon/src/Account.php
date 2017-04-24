<?php

namespace Revolution\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Account
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
     * @param string $client_name
     * @param string $redirect_uris
     * @param array  $scopes
     * @param string $website
     *
     * @return array
     */
    public function verify_credentials(string $domain): array
    {

        $response = $this->client->get($domain . '/api/v1/accounts/verify_credentials', [
                'headers' =>
                    ['Authorization' => 'Bearer ' . $this->token],
            ]
        );

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
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
