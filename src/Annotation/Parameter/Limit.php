<?php

namespace App\Annotation\Parameter;

use Doctrine\Common\Annotations\Annotation\Target;
use FOS\RestBundle\Controller\Annotations\ParamInterface;
use FOS\RestBundle\Validator\Constraints\Regex;
use Swagger\Annotations\Parameter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Limit extends Parameter implements ParamInterface
{
    public function __construct(
        array $properties
    ) {
        parent::__construct($properties);

        $this->name = 'limit';
        $this->in = 'query';
        $this->description = "Defines list's page length";
        $this->type = 'integer';
        $this->allowEmptyValue = false;
        $this->required = true;
        $this->default = 10;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault(): int
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
        $pattern = '/^\d+$/';
        return [new Regex($pattern)];
    }

    public function isStrict(): bool
    {
        return false;
    }

    public function getValue(Request $request, $default)
    {
        return $request->query->get($this->name, $default);
    }
}
