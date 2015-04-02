<?php

namespace ScoreYa\Cinderella\Template\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Core\Processor\BaseFlushProcessor;
use ScoreYa\Cinderella\Template\Event\TemplateEvent;
use ScoreYa\Cinderella\Template\Model\Template;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TemplateFlushProcessor extends BaseFlushProcessor
{
    private $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param DocumentManager $dm
     * @param mixed           $doc
     *
     * @return void
     */
    public function process(DocumentManager $dm, $doc)
    {
        if ($this->isCreated($dm, $doc)) {
            $this->eventDispatcher->dispatch(TemplateEvent::CREATED, new TemplateEvent($doc));
        }

        if ($this->isUpdated($dm, $doc)) {
            $this->eventDispatcher->dispatch(TemplateEvent::UPDATED, new TemplateEvent($doc));
        }
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supports($class)
    {
        return is_a($class, Template::class, true);
    }
}
