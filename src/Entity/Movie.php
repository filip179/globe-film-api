<?php

namespace App\Entity;

use App\Entity\Component\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 * @ORM\Table(name="movie")
 */
class Movie extends BaseEntity
{
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Groups("base")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Groups("base")
     */
    private $director;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;
    /**
     * @var Rate[]
     * @ORM\OneToMany(targetEntity="Rate", mappedBy="movie")
     * @Groups({"none"})
     */
    private $ratings;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min="1.0", max="5.0")
     * @Groups("base")
     */
    private $rate;

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param mixed $director
     */
    public function setDirector($director): void
    {
        $this->director = $director;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return Rate[]
     */
    public function getRatings(): array
    {
        return $this->ratings;
    }

    /**
     * @param Rate[] $ratings
     */
    public function setRatings(array $ratings): void
    {
        $this->ratings = $ratings;
    }
}
