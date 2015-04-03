<?php

namespace ScoreYa\Cinderella\Template\EventListener;

use ScoreYa\Cinderella\Template\Event\TemplateEvent;
use ScoreYa\Cinderella\Template\Loader\UpdateableLoaderInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage24.com>
 */
class UpdateTemplateVariables
{
    private $loader;

    /**
     * @param UpdateableLoaderInterface $loader
     */
    public function __construct(UpdateableLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function update(TemplateEvent $event)
    {
        $this->loader->update($event->getTemplate());
    }
}
