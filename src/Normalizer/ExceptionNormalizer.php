<?php

namespace App\Normalizer;

use App\Exception\BadRequestHttpException;
use FOS\RestBundle\Util\ExceptionValueMap;
use FOS\RestBundle\Serializer\Normalizer\ExceptionNormalizer as FOSExceptionNormalizer;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ExceptionNormalizer extends FOSExceptionNormalizer
{
    private const FIELD_CODE = 'code';
    private const FIELD_ERROR = 'error';
    private const FIELD_PATH = 'path';
    private const FIELD_MESSAGE = 'message';
    private const FIELD_VIOLATIONS = 'violations';
    private const FIELD_TRACE = 'trace';

    private $converter;

    public function __construct(ExceptionValueMap $messagesMap, CamelCaseToSnakeCaseNameConverter $converter)
    {
        $this->converter = $converter;

        parent::__construct($messagesMap, false);
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $response = [
            self::FIELD_CODE => ($object instanceof HttpException) ? $object->getStatusCode() : 500,
            self::FIELD_ERROR => [
                self::FIELD_MESSAGE => $object->getMessage()
            ]
        ];

        if ($object instanceof BadRequestHttpException) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($object->getConstraintViolationList() as $violation) {
                $response[self::FIELD_ERROR][self::FIELD_VIOLATIONS][] = [
                    self::FIELD_PATH => $this->converter->normalize($violation->getPropertyPath()),
                    self::FIELD_MESSAGE => $violation->getMessage()
                ];
            }
        } elseif (!$object instanceof HttpException) {
            $response[self::FIELD_ERROR][self::FIELD_TRACE] = $object->getTrace();
        }

        return $response;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof Exception;
    }
}
