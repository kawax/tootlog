<?php

namespace Tests\Unit;

use App\Support\Header;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_since()
    {
        $response = new Response(
            200,
            ['Link' => '<https://example.com/api/v1/accounts/1/statuses?limit=2&max_id=7486869>; rel="next", <https://example.com/api/v1/accounts/1/statuses?limit=2&since_id=7489740>; rel="prev"'],
            'test'
        );

        $this->assertEquals('7489740', Header::since($response));
    }

    public function test_min()
    {
        $response = new Response(
            200,
            ['Link' => '<https://example.com/api/v1/accounts/1/statuses?limit=2&max_id=7486869>; rel="next", <https://example.com/api/v1/accounts/1/statuses?limit=2&min_id=7489740>; rel="prev"'],
            'test'
        );

        $this->assertEquals('7489740', Header::since($response));
    }
}
