<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Request\ParamFetcherInterface;

class MovieRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findByParams(ParamFetcherInterface $fetcher, array $filters)
    {
        $query = $this->createQueryBuilder('t');

        $this->paginate(
            $query,
            $fetcher->get('limit') ?? 10,
            $fetcher->get('page') ?? 1
        );

        if ($filters['search'] !== null) {
            $this->search($query, $filters['search']);
        }

        return $query->getQuery()->getResult();
    }

    private function paginate(QueryBuilder $query, int $limit, int $page)
    {
        $query
            ->setFirstResult($page * $limit)
            ->setMaxResults($limit);
    }

    private function search(QueryBuilder $query, string $searchExpr = null)
    {
        if ($searchExpr !== null) {
            $query
                ->where($query->expr()->like('t.title', ':search1'))
                ->orWhere($query->expr()->like('t.description', ':search2'))
                ->orWhere($query->expr()->like('t.director', ':search3'))
                ->setParameters([
                    'search1' => '%' . $searchExpr . '%',
                    'search2' => '%' . $searchExpr . '%',
                    'search3' => '%' . $searchExpr . '%'
                ]);
        }
    }

    public function getCount(array $filters)
    {
        $query = $this->createQueryBuilder('t')
            ->select('COUNT(t.id)');

        if ($filters['search'] !== null) {
            $this->search($query, $filters['search']);
        }

        return (int)$query->getQuery()->getSingleScalarResult();
    }
}