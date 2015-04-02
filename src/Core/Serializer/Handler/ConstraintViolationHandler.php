<?php

namespace ScoreYa\Cinderella\Core\Serializer\Handler;

use JMS\Serializer\Handler\ConstraintViolationHandler as BaseConstraintViolationHandler;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class ConstraintViolationHandler extends BaseConstraintViolationHandler
{
    /**
     * @param JsonSerializationVisitor $visitor
     * @param ConstraintViolation      $violation
     * @param null|array               $type
     *
     * @return array<string,string>
     */
    public function serializeViolationToJson(
        JsonSerializationVisitor $visitor,
        ConstraintViolation $violation,
        array $type = null
    ) {
        $data = [
            'propertyPath' => $violation->getPropertyPath(),
            'message'      => $violation->getMessage()
        ];

        if (null === $visitor->getRoot()) {
            $visitor->setRoot($data);
        }

        return $data;
    }
}
