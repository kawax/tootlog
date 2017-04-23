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
     * @param string $scopes
     * @param string $website
     *
     * @return string
     */
    public function register(
        string $domain,
        string $client_name,
        string $redirect_uris,
        string $scopes,
        string $website = ''
    ): string {

        $response = $this->client->post(trim($domain, "/\t\n\r\0\x0B") . '/api/v1/apps', [
                'form_params' =>
                    compact('client_name', 'redirect_uris', 'scopes', 'website'),
            ]
        );

        return (string)$response->getBody();
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
