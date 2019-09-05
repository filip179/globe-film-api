<?php

namespace App\Annotation\Response;

use Doctrine\Common\Annotations\Annotation\Target;
use Swagger\Annotations\Response;

/**
 * @Annotation
 * @Target({"METHOD", "ANNOTATION"})
 */
class Error409 extends Response
{
    public function __construct(array $properties)
    {
        parent::__construct($properties);

        $this->response = 409;
        $this->description = 'Conflict';
    }
}
