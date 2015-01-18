<?php

namespace ScoreYa\Cinderella\Tests\Core\EventListener;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Event\OnFlushEventArgs;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Core\EventListener\DocumentFlushListener;
use ScoreYa\Cinderella\Core\Processor\FlushProcessor;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\EventListener\DocumentFlushListener
 */
class DocumentFlushListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $processor;

    /**
     * @var DocumentFlushListener
     */
    private $listener;

    /**
     * @test
     */
    public function doNothingIfNoProcessorIsFound()
    {
        $event = $this->prophesize(OnFlushEventArgs::class);
        $dm = $this->prophesize(DocumentManager::class);
        $uow = $this->prophesize(UnitOfWork::class);

        $event->getDocumentManager()->willReturn($dm->reveal());

        $uow->getIdentityMap()->willReturn(['otherClass' => []]);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $this->processor->supports('otherClass')->willReturn(false);

        $this->listener->onFlush($event->reveal());
    }

    /**
     * @test
     */
    public function processDocument()
    {
        $event = $this->prophesize(OnFlushEventArgs::class);
        $dm = $this->prophesize(DocumentManager::class);
        $uow = $this->prophesize(UnitOfWork::class);

        $event->getDocumentManager()->willReturn($dm->reveal());

        $uow->getIdentityMap()->willReturn(['otherClass' => [['doc']]]);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $this->processor->supports('otherClass')->willReturn(true);
        $this->processor->process($dm, ['doc'])->shouldBeCalled();

        $this->listener->onFlush($event->reveal());
    }

    protected function setUp()
    {
        $this->listener = new DocumentFlushListener();
        $this->processor = $this->prophesize(FlushProcessor::class);
        $this->listener->addProcessor($this->processor->reveal());
    }
}
