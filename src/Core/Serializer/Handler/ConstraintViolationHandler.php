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
     * @param array                    $type
     *
     * @return array
     */
    public function serializeViolationToJson(
        JsonSerializationVisitor $visitor,
        ConstraintViolation $violation,
        array $type = null
    ) {
        $data = array(
            'propertyPath' => $violation->getPropertyPath(),
            'message'       => $violation->getMessage(),
        );

        if (null === $visitor->getRoot()) {
            $visitor->setRoot($data);
        }

        return $data;
    }
}
