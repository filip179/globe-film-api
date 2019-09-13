<?php

namespace App\Tests\Fixture;


class RatingMovies extends MoviesCanBeFiltered
{
    public function load(): void
    {
        $this->manager->getConnection()->prepare('DELETE FROM rate;')->execute();
        parent::load();
    }
}