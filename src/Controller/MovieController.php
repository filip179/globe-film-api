<?php

namespace App\Controller;

use App\Annotation\Parameter;
use App\Service\MovieDataService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieController extends BaseController
{
    private $movieDataService;

    public function __construct(MovieDataService $movieDataService)
    {
        $this->movieDataService = $movieDataService;
    }

    /**
     * @Rest\Get(path="/movie", name="movie_index")
     * @Parameter\Page()
     * @Parameter\Limit()
     */
    public function index(Request $request)
    {
        [$result, $count, $limit] = $this->movieDataService->list($request);

        return $this->createListView($result, $count, $limit);
    }

    /**
     * @Rest\Get(path="/movie/{id}", name="movie_show")
     */
    public function show($id)
    {
        $movie = $this->movieDataService->show($id);

        if ($movie === null) {
            throw  new NotFoundHttpException('Movie not found.');
        }

        return $this->createObjectView($movie, 'detailed');
    }
}
