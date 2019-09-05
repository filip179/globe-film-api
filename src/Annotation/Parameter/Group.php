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
class Group extends Parameter implements ParamInterface
{
    public function __construct(
        array $properties
    ) {
        parent::__construct($properties);

        $this->name = 'group';
        $this->in = 'query';
        $this->description = 'Defines fields to be returned';
        $this->type = 'string';
        $this->allowEmptyValue = false;
        $this->required = true;

        if (!is_array($this->enum)) {
            $this->enum = [$this->enum ?? 'base'];
        }
        if (!in_array('base', $this->enum, false)) {
            $this->enum[] = 'base';
        }
        $this->default = $this->enum[0];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault(): string
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
        $pattern = '/^(' . implode('|', $this->enum) . ')$/';
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
