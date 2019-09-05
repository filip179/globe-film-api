<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class BaseRepositoryFactory
{
    private $container;
    private $em;

    public function __construct(ContainerInterface $container, EntityManagerInterface $em)
    {
        $this->container = $container;
        $this->em = $em;
    }

    public function create(string $entityName): BaseRepository
    {
        if (!class_exists($entityName)) {
            throw new RuntimeException($entityName . ' not found!', );
        }

        $repositoryName = $entityName . 'Repository';

        if (!$this->container->has($repositoryName)) {
            $this->container->set($repositoryName, new BaseRepository($this->em, $entityName));
        }

        return $this->container->get($repositoryName);
    }
}
