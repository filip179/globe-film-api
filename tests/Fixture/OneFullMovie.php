<?php

namespace App\Tests\Fixture;

use App\Entity\Movie;

class OneFullMovie extends AppFixture
{
    public function load()
    {
        $movie = new Movie();
        $movie->setDescription('Aaaa');
        $movie->setTitle('Aaaa');
        $movie->setDirector('Aaaa Aaaa');
        $movie->setRate(4.5);
        $this->manager->persist($movie);
        $this->manager->flush();

        return $this->manager->getConnection()->lastInsertId();
    }
}