<?php

namespace App\Tests\Components;

use GuzzleHttp\Client;

trait HttpClientTrait
{
    protected $http;

    protected function setUp()
    {
        $this->http = new Client(getenv('APP_HOST') ?? 'http://localhost/', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));
    }
}