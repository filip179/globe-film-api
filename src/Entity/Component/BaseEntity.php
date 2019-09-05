<?php

namespace App\Entity\Component;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass()
 */
abstract class BaseEntity implements IdentifiableInterface, TimestampableInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;
}
