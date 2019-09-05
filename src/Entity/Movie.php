<?php

namespace App\Entity;

use App\Entity\Component\BaseEntity;

class Movie extends BaseEntity
{
    /**
     * @var string
     *
     */
private $title;
private $director;
private $description;
private $ratings;
private $duration;

}