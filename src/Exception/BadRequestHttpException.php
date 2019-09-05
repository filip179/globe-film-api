<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException as CoreBadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class BadRequestHttpException extends CoreBadRequestHttpException
{
    private $constraintViolationList;

    /**
     * @param ConstraintViolationListInterface  $list       The list of constraints violated
     * @param string                            $message    The internal exception message
     * @param Throwable                         $previous   The previous exception
     * @param int                               $code       The internal exception code
     * @param array                             $headers
     */
    public function __construct(
        ConstraintViolationListInterface $list,
        string $message = null,
        Throwable $previous = null,
        int $code = 0,
        array $headers = []
    ) {
        $this->constraintViolationList = $list;

        parent::__construct($message, $previous, $code, $headers);
    }

    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
