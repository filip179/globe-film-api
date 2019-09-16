<?php

namespace App\Controller\Movie;

use App\Controller\BaseController;
use App\Entity\Rate;
use App\Service\Movie\RateCalculator;
use App\Service\MovieDataService;
use App\Service\RateDataService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RateController extends BaseController
{
    private $movieDataService;
    private $entityManager;
    private $rateCalculator;
    private $rateDataService;

    public function __construct(
        MovieDataService $movieDataService,
        EntityManagerInterface $entityManager,
        RateCalculator $rateCalculator,
        RateDataService $rateDataService
    )
    {
        $this->movieDataService = $movieDataService;
        $this->entityManager = $entityManager;
        $this->rateCalculator = $rateCalculator;
        $this->rateDataService = $rateDataService;
    }

    /**
     * @Rest\Post(path="/movie/{movieId}/rate", name="movie_rate_create")
     */
    public function create($movieId, Request $request)
    {
        $movie = $this->movieDataService->show($movieId);
        if ($movie === null) {
            throw new NotFoundHttpException('Movie not found.');
        }

        $rateValue = (int)$request->get('rate');
        if (!$rateValue) {
            throw  new BadRequestHttpException('Rate is required.');
        }

        $ip = $request->getClientIp();

        $params = [
            'movie' => $movie,
            'ip_address' => $ip,
        ];
        $rate = $this->rateDataService->findByParams($params);
        if ($rate !== null) {
            throw new NotAcceptableHttpException($ip . 'Already voted.');
        }

        $rate = new Rate();
        $rate->setMovie($movie);
        $rate->setRate($rateValue);
        $rate->setIpAddress($ip);
        $this->validate($rate, 'base');
        $this->entityManager->persist($rate);

        //TODO AMQP, Performance test
        [$count, $sum] = $this->rateDataService->sumData($movie);
        $newRate = $this->rateCalculator->calculate($count, $sum);
        $movie->setRate($newRate);
        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $this->createView(null, Response::HTTP_CREATED);
    }
}