<?php

namespace ScoreYa\Cinderella\Core\Validator\Constraints;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class EqualsFieldValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $accessor   = PropertyAccess::createPropertyAccessor();
        $otherValue = $accessor->getValue($this->context->getRoot(), $constraint->field);

        if ($value !== $otherValue) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ field }}', $constraint->field)
                ->addViolation();
        }
    }
}