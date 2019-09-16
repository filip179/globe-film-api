<?php

namespace App\Tests\Feature\Movie;

use App\Tests\Components\AppTestCase;
use App\Tests\Fixture\OneFullMovie;
use Symfony\Component\HttpFoundation\Response;

class ShowingMovieTest extends AppTestCase
{
    /** @test */
    function anybody_can_see_a_movie()
    {
        $this->loadFixture(OneFullMovie::class);

        $result = $this->get('/api/v1/movie/1');

        $this->assertEquals(Response::HTTP_OK, $result->getStatusCode());
    }

    /** @test */
    function movie_has_description()
    {
        $id = $this->loadFixture(OneFullMovie::class);

        $result = $this->get('/api/v1/movie/'. $id);

        $this->assertJsonResponse([
            'id' => $id,
            'title' => 'Aaaa',
            'description' => 'Aaaa',
            'director' => 'Aaaa',
            'rate' => 4.5
        ]);

        $this->assertEquals(Response::HTTP_OK, $result->getStatusCode());
    }

    /** @test */
    function not_found_when_bad_id_provided()
    {
        $result = $this->get('/api/v1/movie/666');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $result->getStatusCode());
    }
}