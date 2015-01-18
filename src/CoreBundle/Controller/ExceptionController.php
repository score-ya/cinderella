<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ExceptionController extends BaseExceptionController
{
    protected function getFormat(Request $request, $format)
    {
        $resolvedFormat = parent::getFormat($request, $format);
        if ($resolvedFormat !== $format) {
            return $format;
        }

        return $resolvedFormat;
    }
}
