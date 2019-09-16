<?php

namespace App\Service;

use App\Entity\Movie;
use App\Entity\Rate;
use App\Repository\RateRepository;

class RateDataService
{
    private $rateRepository;

    public function __construct(RateRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function sumData(Movie $movie): array
    {
        return [
            $this->rateRepository->countRatesByMovieId($movie),
            $this->rateRepository->sumRatesByMovieId($movie),
        ];
    }

    public function findByParams($params): ?Rate
    {
        return $this->rateRepository->findRate($params);
    }
}
