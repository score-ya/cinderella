<?php

namespace ScoreYa\Cinderella\Core\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
abstract class BaseFlushProcessor implements FlushProcessor
{
    /**
     * @param DocumentManager $dm
     * @param mixed           $doc
     *
     * @return boolean
     */
    protected function isCreated(DocumentManager $dm, $doc)
    {
        $changeSet = $dm->getUnitOfWork()->getDocumentChangeSet($doc);
        $state     = $dm->getUnitOfWork()->getDocumentState($doc);

        return $state === UnitOfWork::STATE_MANAGED
        && (count($changeSet) === 0 || $this->hasNewId($changeSet)) === true;
    }

    /**
     * @param DocumentManager $dm
     * @param mixed           $doc
     *
     * @return boolean
     */
    protected function isUpdated(DocumentManager $dm, $doc)
    {
        $changeSet = $dm->getUnitOfWork()->getDocumentChangeSet($doc);
        $state     = $dm->getUnitOfWork()->getDocumentState($doc);

        return $state === UnitOfWork::STATE_MANAGED && count($changeSet) > 0 && $this->hasNewId($changeSet) === false;
    }

    /**
     * @param array $changeSet
     *
     * @return bool
     */
    private function hasNewId(array $changeSet)
    {
        if (count($changeSet) > 0 && array_key_exists('id', $changeSet) === true) {
            return $changeSet['id'][0] === null && $changeSet['id'][1] !== null;
        }

        return false;
    }
}
