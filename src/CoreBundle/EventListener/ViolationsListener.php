<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use ScoreYa\Cinderella\Core\Controller\Violations;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class ViolationsListener
{
    private $validationErrorsArgument;

    /**
     * @param string $validationErrorsArgument
     */
    public function __construct($validationErrorsArgument)
    {
        $this->validationErrorsArgument = $validationErrorsArgument;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function checkViolation(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        $violations = $request->attributes->get($this->validationErrorsArgument);
        if ($violations instanceof ConstraintViolationListInterface && $violations->count() > 0) {
            $request->attributes->set('_view', new View(['statusCode' => 400]));

            $event->setController(new Violations());
        }
    }
}
