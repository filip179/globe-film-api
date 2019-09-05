<?php

namespace App\Tests\Feature\Movie;

use App\Tests\Components\AppTestCase;
use App\Tests\Components\HttpClientTrait;

class ListingMoviesTest extends AppTestCase
{
    /** @test */
    function anybody_can_list_movies()
    {
$result = $this->http->get('/movie');

    }

    /** @test */
    function movies_can_be_filtered_by_title()
    {

    }

    /** @test */
    function movies_can_be_filtered_by_author()
    {

    }

    /** @test */
    function movies_can_be_filtered_by_duration()
    {

    }

    /** @test */
    function movies_can_be_filtered_by_rating()
    {

    }

    /** @test */
    function movies_by_default_are_ordered_by_title_ascending()
    {

    }

    /** @test */
    function movies_can_be_ordered_by_author()
    {

    }

    /** @test */
    function movies_can_be_ordered_by_duration()
    {

    }

    /** @test */
    function movies_can_be_ordered_by_rating()
    {

    }

    /** @test */
    function movies_can_be_searched()
    {

    }

    /** @test */
    function empty_array_is_returned_when_no_movies()
    {

    }
}