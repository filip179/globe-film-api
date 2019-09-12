<?php

namespace App\Service;

use App\Repository\MovieRepository;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;

class MovieDataService
{
    private $paramFetcher;
    private $repository;

    public function __construct(ParamFetcherInterface $fetcher, MovieRepository $repository)
    {
        $this->paramFetcher = $fetcher;
        $this->repository = $repository;
    }

    public function list(Request $request): array
    {
        $filters = [
            'search' => $request->get('search'),
            'title' => $request->get('title'),
            'director' => $request->get('director')
        ];

        $result = [
            $this->repository->findByParams($this->paramFetcher, $filters),
            $this->repository->getCount($filters),
            $this->paramFetcher->get('limit'),
        ];

        return $result;
    }

    public function show(int $id)
    {
        return $this->repository->find($id);
    }

}