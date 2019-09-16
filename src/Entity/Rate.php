<?php

namespace App\Entity;

use App\Entity\Component\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="rate")
 */
class Rate extends BaseEntity
{
    /**
     * @ORM\Column
     * @Groups("base")
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="float")
     *
     * @Assert\Range(
     *     min = 1,
     *     max = 5,
     *     minMessage="Rate must be greater or equals 1.",
     *     maxMessage="Rate must be less or equals 5.",
     * )
     *
     * @Groups("base")
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="ratings")
     * @Groups("none")
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
