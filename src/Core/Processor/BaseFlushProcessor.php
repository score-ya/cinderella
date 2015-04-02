<?php

namespace ScoreYa\Cinderella\Core\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
abstract class BaseFlushProcessor implements FlushProcessor
{

    const CREATED = 'created';
    const UPDATED = 'updated';

    /**
     * @param string          $type
     * @param DocumentManager $dm
     * @param mixed           $doc
     *
     * @return bool
     */
    protected function isType($type, DocumentManager $dm, $doc)
    {

        $changeSet = $dm->getUnitOfWork()->getDocumentChangeSet($doc);
        $state     = $dm->getUnitOfWork()->getDocumentState($doc);

        switch ($type) {
            case self::CREATED :
                return $state === UnitOfWork::STATE_MANAGED
                && (count($changeSet) === 0 || $this->hasNewId($changeSet)) === true;
                break;
            case self::UPDATED:
                return $state === UnitOfWork::STATE_MANAGED && count($changeSet) > 0
                && $this->hasNewId($changeSet) === false;
                break;
            default:
                return false;
                break;
        }
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
