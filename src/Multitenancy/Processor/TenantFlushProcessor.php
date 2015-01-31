<?php

namespace ScoreYa\Cinderella\Multitenancy\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Core\Processor\BaseFlushProcessor;
use ScoreYa\Cinderella\Multitenancy\Event\TenantEvent;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TenantFlushProcessor extends BaseFlushProcessor
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
     */
    public function process(DocumentManager $dm, $doc)
    {
        if ($this->isCreated($dm, $doc)) {
            $this->eventDispatcher->dispatch(TenantEvent::CREATED, new TenantEvent($doc));
        }
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supports($class)
    {
        return is_a($class, Tenant::class, true);
    }
}
