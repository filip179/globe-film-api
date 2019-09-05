<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

final class BaseRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, string $class)
    {
        parent::__construct($em, new Mapping\ClassMetadata($class));
    }
}
