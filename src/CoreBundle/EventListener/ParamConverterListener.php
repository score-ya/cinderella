<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\EventListener;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class ParamConverterListener
{
    /**
     * Modifies the ParamConverterManager instance.
     *
     * @param FilterControllerEvent $event A FilterControllerEvent instance
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if ($converters = $request->attributes->get('_converters')) {
            foreach ($converters as $key => $configuration) {
                $converters[$key] = new ParamConverter($configuration);
            }

            $request->attributes->set('_converters', $converters);
        }
    }
}
