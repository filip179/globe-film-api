<?php

namespace App\Repository;

use App\Entity\Rate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }

    public function countRatesByMovieId($movie)
    {
        $query = $this->createQueryBuilder('t');

        $query
            ->select('COUNT(t.id)')
            ->andWhere('t.movie = :movie')
            ->setParameter('movie', $movie);

        return (int)$query->getQuery()->getScalarResult();
    }

    public function sumRatesByMovieId($movie)
    {
        $query = $this->createQueryBuilder('t');

        $query
            ->select('SUM(t.rate)')
            ->andWhere('t.movie = :movie')
            ->setParameter('movie', $movie);

        return (int)$query->getQuery()->getScalarResult();
    }

    public function findRate(array $params)
    {
        $query = $this->createQueryBuilder('t');

        $query->andWhere('t.ipAddress = :ip_address')
            ->andWhere('t.movie = :movie')
            ->setParameters($params);

        return $query->getQuery()->getFirstResult();
    }

}