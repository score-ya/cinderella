<?php

namespace ScoreYa\Cinderella\Core\EventListener;

use Doctrine\ODM\MongoDB\Event\ManagerEventArgs;
use ScoreYa\Cinderella\Core\Processor\FlushProcessor;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class DocumentFlushListener
{
    /**
     * @var FlushProcessor[]
     */
    private $flushProcessors = array();

    /**
     * @param FlushProcessor $flushProcessor
     */
    public function addProcessor(FlushProcessor $flushProcessor)
    {
        $this->flushProcessors[] = $flushProcessor;
    }

    /**
     * @param string $class
     *
     * @return FlushProcessor
     */
    private function getFlushProcessor($class)
    {
        foreach ($this->flushProcessors as $flushProcessor) {
            if ($flushProcessor->supports($class)) {
                return $flushProcessor;
            }
        }

        return false;
    }

    /**
     * @param ManagerEventArgs $event
     */
    public function preFlush(ManagerEventArgs $event)
    {
        $dm  = $event->getDocumentManager();
        $uow = $dm->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $class => $docs) {
            if ($result = $this->getFlushProcessor($class)) {
                foreach ($docs as $doc) {
                    $result->process($dm, $doc);
                }
            }
        }
    }
}
