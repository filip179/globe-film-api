<?php

namespace App\Tests\Fixture;

use App\Entity\Movie;
use Doctrine\Common\Persistence\ObjectManager;

class AnybodyCanListMovies extends AppFixture
{
    public function load(): void
    {
        $movie = new Movie();
        $movie->setDescription('Aaaa');
        $movie->setTitle('Aaaa');
        $movie->setDirector('Aaaa Aaaa');
        $movie->setRate(1);

        $this->manager->persist($movie);
        $this->manager->flush();
    }
}