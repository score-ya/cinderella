<?php

namespace ScoreYa\Cinderella\Template\EventListener;

use Behat\Transliterator\Transliterator;
use ScoreYa\Cinderella\Template\Event\TemplateEvent;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SetApiName
{
    /**
     * @param TemplateEvent $event
     */
    public function __invoke(TemplateEvent $event)
    {
        $template = $event->getTemplate();

        $apiName = mb_strtolower(Transliterator::urlize(Transliterator::transliterate($template->getName())));

        $template->setApiName($apiName);
    }
}
