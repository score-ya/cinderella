<?php

namespace ScoreYa\Cinderella\Multitenancy\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use ScoreYa\Cinderella\Core\Processor\FlushProcessor;
use ScoreYa\Cinderella\Multitenancy\Event\TenantEvent;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TenantFlushProcessor implements FlushProcessor
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
        $changeSet = $dm->getUnitOfWork()->getDocumentChangeSet($doc);
        $state     = $dm->getUnitOfWork()->getDocumentState($doc);

        if (count($changeSet) === 0 && $state === UnitOfWork::STATE_MANAGED) {
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
