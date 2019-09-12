<?php

namespace App\Tests\Feature\Movie;

use App\Tests\Components\AppTestCase;
use App\Tests\Fixture\AnybodyCanListMovies;
use App\Tests\Fixture\MoviesCanBeFiltered;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;


class ListingMoviesTest extends AppTestCase
{
    use RefreshDatabaseTrait;

    /** @test */
    function anybody_can_list_movies()
    {
        $this->loadFixture(AnybodyCanListMovies::class);

        $result = $this->get('/api/v1/movie');
        $this->assertEquals($result->getStatusCode(), Response::HTTP_OK);
    }

    /** @test */
    function movies_can_be_filtered_by_title()
    {
        $this->loadFixture(MoviesCanBeFiltered::class);

        $result = $this->get('/api/v1/movie', ['title' => 'Title1']);
        $this->assertEquals($result->getStatusCode(), Response::HTTP_OK);
        $this->assertJsonResponse(['data' => [
            [
                'title' => 'Title1',
                'director' => 'Director1',
                'rate' => 1,
                'id'=> 1,
            ]
        ]]);
    }

    /** @test */
    function movies_can_be_filtered_by_director()
    {
        $this->loadFixture(MoviesCanBeFiltered::class);

        $result = $this->get('/api/v1/movie', ['director' => 'Director2']);
        $this->assertEquals($result->getStatusCode(), Response::HTTP_OK);
        $this->assertJsonResponse(['data' => [
            [
                'title' => 'Title2',
                'director' => 'Director2',
                'rate' => 2,
                'id'=> 2,
            ]
        ]]);
    }

    /** @test */
    function movies_can_be_filtered_by_rating()
    {
        $this->loadFixture(MoviesCanBeFiltered::class);

        $result = $this->get('/api/v1/movie', ['rating' => '2.0']);
        $this->assertEquals($result->getStatusCode(), Response::HTTP_OK);
        $this->assertJsonResponse(['data' => [
            [
                'title' => 'Title2',
                'director' => 'Director2',
                'rate' => 2,
                'id'=> 2,
            ]
        ]]);
    }

    /** @test */
    function movies_can_be_searched()
    {
        $this->loadFixture(MoviesCanBeFiltered::class);

        $result = $this->get('/api/v1/movie', ['search' => 'Title1']);
        $this->assertEquals($result->getStatusCode(), Response::HTTP_OK);
        $this->assertJsonResponse(['data' => [
            [
                'title' => 'Title1',
                'director' => 'Director1',
                'rate' => 1,
                'id'=> 1,
            ]
        ]]);
    }

    /** @test */
    function empty_array_is_returned_when_no_movies()
    {
        $result = $this->get('/api/v1/movie');

        $this->assertEquals($result->getStatusCode(), Response::HTTP_OK);

        $data = json_decode($result->getBody()->getContents());
        $this->assertEquals([], $data->data);
        $this->assertEquals(0, $data->meta->total_count);
    }
}