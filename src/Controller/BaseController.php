<?php

namespace App\Controller;

use App\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractFOSRestController
{
    private $validator;

    public function __construct(
        ValidatorInterface $validator
    )
    {
        $this->validator = $validator;
    }

    protected function createObjectView(
        $object,
        string $group = 'base',
        int $statusCode = 200,
        bool $timestamped = false
    ): Response
    {
        $view = $this->view($object, $statusCode);
        $view->getContext()->setGroups(['base', $group]);

        if ($timestamped) {
            $view->getContext()->addGroup('timestamp');
        }

        return $this->handleView($view);
    }

    protected function createView($data = null, int $statusCode = 204): Response
    {
        $view = $this->view($data, $statusCode);

        return $this->handleView($view);
    }

    protected function createListView(
        array $objects,
        int $totalCount,
        int $limit,
        string $group = 'base',
        int $statusCode = 200
    ): Response
    {
        $view = $this->view(
            [
                'meta' => [
                    'total_count' => $totalCount,
                    'page_count' => $totalCount / $limit
                ],
                'data' => $objects
            ],
            $statusCode
        );
        $view->getContext()->setGroups(['base', $group]);

        return $this->handleView($view);
    }

    /**
     * @param string $data
     * @param string $class
     * @param string $group
     * @param object|null $possessor Instance to populate
     *
     * @return object
     */
    protected function deserialize(
        string $data,
        string $class,
        string $group,
        $possessor = null
    )
    {
        $options = ['groups' => [$group]];
        if ($possessor) {
            $options['object_to_populate'] = $possessor;
        }

        return $this->getSerializer()->deserialize(
            $data,
            $class,
            'json',
            $options
        );
    }

    private function getSerializer(): SerializerInterface
    {
        return $this->get('serializer');
    }

    protected function validate($instance, string $group): void
    {
        $violations = $this->validator->validate($instance, null, $group);
        if ($violations->count() > 0) {
            throw new BadRequestHttpException($violations);
        }
    }
}
