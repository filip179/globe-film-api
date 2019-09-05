<?php

namespace App\Entity\Component;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations\Property;

trait IdentifiableTrait
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     *
     * @Property(
     *     type="integer",
     *     example=42
     * )
     * @Groups("base")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
