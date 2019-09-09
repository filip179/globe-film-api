<?php

namespace App\Tests\Components;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTestCase extends KernelTestCase
{
    protected $manager;
    /** @var Client */
    protected $http;

    protected function get(string $uri)
    {
        $baseUrl = getenv('APP_HOST') ?? 'http://localhost';

        return $this->http->request('GET', $baseUrl . $uri, ['headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ]]);
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $this->http = new Client([
            'exceptions' => false,
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->manager->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->manager->getConnection()->prepare('SET FOREIGN_KEY_CHECKS = 0;')->execute();

        $tables = $this->manager->getConnection()->getSchemaManager()->listTableNames();
        foreach ($tables as $tableName) {
            $sql = 'DELETE FROM `' . $tableName . '` WHERE 1=1';
            $this->manager->getConnection()->prepare($sql)->execute();
        }

        $this->manager->getConnection()->prepare('SET FOREIGN_KEY_CHECKS = 1;')->execute();
    }


}