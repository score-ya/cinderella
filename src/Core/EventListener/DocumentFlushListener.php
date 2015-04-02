<?php

namespace ScoreYa\Cinderella\Core\EventListener;

use Doctrine\ODM\MongoDB\Event\OnFlushEventArgs;
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
     * @return FlushProcessor|null
     */
    private function getFlushProcessor($class)
    {
        foreach ($this->flushProcessors as $flushProcessor) {
            if ($flushProcessor->supports($class)) {
                return $flushProcessor;
            }
        }

        return null;
    }

    /**
     * @param OnFlushEventArgs $event
     */
    public function onFlush(OnFlushEventArgs $event)
    {
        $dm  = $event->getDocumentManager();
        $uow = $dm->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $class => $docs) {
            if ($result = $this->getFlushProcessor($class)) {
                foreach ($docs as $doc) {
                    $result->process($dm, $doc);
                    $uow->recomputeSingleDocumentChangeSet(
                        $dm->getMetadataFactory()->getMetadataFor(get_class($doc)),
                        $doc
                    );
                }
            }
        }
    }
}
