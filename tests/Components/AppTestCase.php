<?php

namespace App\Tests\Components;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AppTestCase extends TestCase
{
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }


    protected function tearDown()
    {
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