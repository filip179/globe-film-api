<?php

namespace App\Controller;

use App\Annotation\Parameter;
use App\Service\MovieDataService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

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
}
