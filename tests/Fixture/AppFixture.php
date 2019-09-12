<?php

namespace App\Tests\Fixture;

use Doctrine\Common\Persistence\ObjectManager;

abstract class AppFixture
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    abstract public function load(): void;
}