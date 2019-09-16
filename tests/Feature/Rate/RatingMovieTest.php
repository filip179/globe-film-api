<?php

namespace App\Tests\Feature\Rate;

use App\Tests\Components\AppTestCase;
use App\Tests\Fixture\RatingMovies;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;

class RatingMovieTest extends AppTestCase
{
    use RefreshDatabaseTrait;

    /** @test */
    function anybody_can_rate_movie()
    {
        $result = $this->post('/api/v1/movie/' . 1 . '/rate', ['rate' => 3.0]);

        $this->assertEquals(
            Response::HTTP_CREATED,
            $result->getStatusCode()
        );
    }

    /** @test */
    function rate_can_be_min_1()
    {
        $result = $this->post('/api/v1/movie/' . 1 . '/rate', ['rate' => 0]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $result->getStatusCode());
    }

    /** @test */
    function rate_can_be_max_5()
    {
        $result = $this->post('/api/v1/movie/' . 1 . '/rate', ['rate' => 6]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $result->getStatusCode());
    }

    /** @test */
    function not_found_when_movie_not_exists()
    {
        $result = $this->post('/api/v1/movie/' . 666 . '/rate', ['rate' => 3.0]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $result->getStatusCode());
    }


    function not_acceptable_when_already_rated()
    {
        $result = $this->post('/api/v1/movie/' . 1 . '/rate', ['rate' => 3.0]);
        $this->assertEquals(Response::HTTP_CREATED, $result->getStatusCode());

        $result = $this->post('/api/v1/movie/' . 1 . '/rate', ['rate' => 4.0]);
        $this->assertEquals(Response::HTTP_NOT_ACCEPTABLE, $result->getStatusCode());
    }

    protected function setUp(): void
    {
        $this->loadFixture(RatingMovies::class);
        parent::setUp();
    }
}

