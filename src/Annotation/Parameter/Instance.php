<?php

namespace App\Annotation\Parameter;

use Doctrine\Common\Annotations\Annotation\Target;
use FOS\RestBundle\Controller\Annotations\ParamInterface;
use Swagger\Annotations\Parameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Instance extends Parameter implements ParamInterface
{
    public function __construct(
        array $properties
    ) {
        parent::__construct($properties);

        $this->in = 'body';
        $this->allowEmptyValue = false;
        $this->required = true;
        $this->default = null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIncompatibilities(): array
    {
        return [];
    }

    public function getConstraints(): array
    {
        return [new NotNull()];
    }

    public function isStrict(): bool
    {
        return false;
    }

    public function getValue(Request $request, $default)
    {
        return $request->getContent();
    }
}
