<?php

namespace App\Tests\Fixture;

use Doctrine\ORM\EntityManagerInterface;

abstract class AppFixture
{
    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    abstract public function load();
}