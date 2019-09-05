<?php

namespace App\Entity\Component;

use DateTime;

interface TimestampableInterface
{
    public function getCreatedAt(): ?DateTime;
    public function getModifiedAt(): ?DateTime;
}
