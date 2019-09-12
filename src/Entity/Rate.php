<?php

namespace App\Entity;

use App\Entity\Component\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="rate")
 */
class Rate extends BaseEntity
{
    /**
     * @ORM\Column
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\Range(min="1", max="5")
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="ratings")
     */
    private $movie;

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie): void
    {
        $this->movie = $movie;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): void
    {
        $this->rate = $rate;
    }
}
