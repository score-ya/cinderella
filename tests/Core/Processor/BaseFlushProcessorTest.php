<?php

namespace ScoreYa\Cinderella\Core\Tests\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use ScoreYa\Cinderella\Core\Processor\BaseFlushProcessor;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\Processor\BaseFlushProcessor
 */
class BaseFlushProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnFalseForWrongType()
    {
        $processor = $this->prophesize(BaseFlushProcessor::class)->reveal();
        $dm        = $this->prophesize(DocumentManager::class);
        $uow       = $this->prophesize(UnitOfWork::class);
        $doc       = new \stdClass();

        $dm->getUnitOfWork()->willReturn($uow->reveal());
        $uow->getDocumentChangeSet($doc)->willReturn([]);
        $uow->getDocumentState($doc)->willReturn(1);

        $refMethod = new \ReflectionMethod($processor, 'isType');
        $refMethod->setAccessible(true);
        $refMethod->invoke($processor, 'other', $dm->reveal(), $doc);

    }
}
