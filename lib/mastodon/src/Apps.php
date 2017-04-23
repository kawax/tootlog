<?php

namespace Revolution\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Apps
{
    /**
     * @var Client
     */
    protected $client;

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
    public function register(
        string $domain,
        string $client_name,
        string $redirect_uris,
        string $scopes,
        string $website = ''
    ): array {

        $response = $this->client->post($domain . '/api/v1/apps', [
                'form_params' =>
                    compact('client_name', 'redirect_uris', 'scopes', 'website'),
            ]
        );

        return json_decode($response->getBody(), true);
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
