<?php

namespace App\Tests\Components;

use App\Tests\Fixture\AppFixture;
use ArrayAccess;
use GuzzleHttp\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use http\Exception\BadConversionException;
use PHPUnit\Framework\Constraint\ArraySubset;
use PHPUnit\Util\InvalidArgumentHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AppTestCase extends KernelTestCase
{
    use RefreshDatabaseTrait;

    /** @var Client */
    protected $http;

    protected $response;

    public function post(string $uri, array $body = [], array $additional = [])
    {
        $baseUrl = getenv('APP_HOST') ?? 'http://localhost';

        $options = [];

        if (!empty($additional)) {
            $options['request.options'] = $additional;
            $options += $additional;
        }

        if (!empty($body)) {
            $options['form_params'] = $body;
        }

        $this->response = $this->http->post($baseUrl . $uri, $options);

        return $this->response;
    }

    public function assertJsonResponse(array $expected)
    {
        $this->assertArrayContains(
            $expected, $this->decodeResponseJson(), true
        );

        return $this;
    }

    public function assertArrayContains(array $subset, array $array, bool $checkForObjectIdentity = false, string $message = '')
    {
        if (!(is_array($subset) || $subset instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array or ArrayAccess'
            );
        }

        if (!(is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                2,
                'array or ArrayAccess'
            );
        }

        $constraint = new ArraySubset($subset, $checkForObjectIdentity);

        static::assertThat($array, $constraint, $message);
    }

    private function decodeResponseJson($key = null)
    {
        $decodedResponse = json_decode($this->response->getBody()->getContents(), true);
        if ($decodedResponse === null || $decodedResponse === false) {
            throw new BadConversionException('Response is not a valid JSON.');
        }

        return $decodedResponse[$key] ?? $decodedResponse;
    }

    public function loadFixture($fixtureName)
    {
        $container = self::bootKernel()->getContainer();

        /** @var AppFixture $fixture */
        if (!in_array(AppFixture::class, class_parents($fixtureName))) {
            throw new \BadFunctionCallException();
        }

        $manager = $container->get('doctrine.orm.entity_manager');

        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $fixture = new $fixtureName($manager);
        return $fixture->load();
    }

    protected function get(string $uri, array $parameters = [])
    {
        $baseUrl = getenv('APP_HOST') ?? 'http://localhost';

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            ],
        ];

        if (!empty($parameters)) {
            $options['query'] = $parameters;
        }

        $this->response = $this->http->request('GET', $baseUrl . $uri, $options);

        return $this->response;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->http = new Client([
            'exceptions' => false,
        ]);
    }
}