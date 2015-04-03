<?php

namespace ScoreYa\Cinderella\Core\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage24.com>
 *
 * @codeCoverageIgnore
 */
class EqualsField extends Constraint
{
    public $message = 'This value does not equal the {{ field }} field';
    public $field;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'field';
    }

    /**
     * {@inheritDoc}
     */
    public function getRequiredOptions()
    {
        return array('field');
    }
}
