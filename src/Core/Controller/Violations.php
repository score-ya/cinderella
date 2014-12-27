<?php

namespace ScoreYa\Cinderella\Core\Controller;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Violations
{
    /**
     * @param $violations ConstraintViolationListInterface
     *
     * @return ConstraintViolationListInterface
     */
    public function __invoke(ConstraintViolationListInterface $violations)
    {
        return $violations;
    }
}
