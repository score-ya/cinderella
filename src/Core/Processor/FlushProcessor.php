<?php

namespace ScoreYa\Cinderella\Core\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
interface FlushProcessor
{
    /**
     * @param DocumentManager $dm
     * @param mixed           $doc
     *
     * @return null
     */
    public function process(DocumentManager $dm, $doc);

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supports($class);
}
