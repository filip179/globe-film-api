<?php

namespace App\Tests\Components;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTestCase extends KernelTestCase
{
    private $manager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->manager->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->manager->getConnection()->prepare("SET FOREIGN_KEY_CHECKS = 0;")->execute();

        $tables = $this->manager->getConnection()->getSchemaManager()->listTableNames();
        foreach ($tables as $tableName) {
            $sql = 'DELETE FROM `' . $tableName . '` WHERE 1=1';
            $this->manager->getConnection()->prepare($sql)->execute();
        }

        $this->manager->getConnection()->prepare('SET FOREIGN_KEY_CHECKS = 1;')->execute();
    }


}