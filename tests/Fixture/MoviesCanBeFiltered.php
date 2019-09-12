<?php

namespace App\Tests\Fixture;

use App\Entity\Movie;

class MoviesCanBeFiltered extends AppFixture
{
    public function load(): void
    {
        $movie1 = new Movie();
        $movie1->setTitle('Title1');
        $movie1->setDirector('Director1');
        $movie1->setDescription('Description1');
        $movie1->setRate(1.0);

        $movie2 = new Movie();
        $movie2->setTitle('Title2');
        $movie2->setDirector('Director2');
        $movie2->setDescription('Description2');
        $movie2->setRate(2.0);

        $this->manager->persist($movie1);
        $this->manager->persist($movie2);
        $this->manager->flush();
    }
}