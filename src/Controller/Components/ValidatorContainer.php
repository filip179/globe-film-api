<?php

namespace App\Controller\Components;

use Symfony\Component\Validator\Validator\ValidatorInterface;

interface ValidatorContainer
{
    public function setValidator(ValidatorInterface $validator);

    public function validate($instance, string $group): void;
}