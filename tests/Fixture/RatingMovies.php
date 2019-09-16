<?php

namespace App\Tests\Fixture;


class RatingMovies extends MoviesCanBeFiltered
{
    public function load()
    {
        $this->manager->getConnection()->prepare('DELETE FROM rate;')->execute();
        parent::load();
    }
}