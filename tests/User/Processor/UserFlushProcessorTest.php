<?php

namespace ScoreYa\Cinderella\User\Tests\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\User\Event\UserEvent;
use ScoreYa\Cinderella\User\Model\User;
use ScoreYa\Cinderella\User\Processor\UserFlushProcessor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\User\Processor\UserFlushProcessor
 */
class UserFlushProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserFlushProcessor
     */
    private $processor;

    /**
     * @var ObjectProphecy
     */
    private $dispatcher;

    /**
     * @test
     */
    public function processNewObject()
    {
        $dm = $this->prophesize(DocumentManager::class);
        $uow = $this->prophesize(UnitOfWork::class);
        $user = $this->prophesize(User::class);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $uow->getDocumentChangeSet($user)->willReturn([]);
        $uow->getDocumentState($user)->willReturn(UnitOfWork::STATE_MANAGED);

        $this->dispatcher->dispatch('cinderella.user.created', Argument::type(UserEvent::class))->shouldBeCalled();

        $this->processor->process($dm->reveal(), $user->reveal());
    }

    /**
     * @test
     */
    public function supports()
    {
        $this->assertTrue($this->processor->supports(User::class));
        $this->assertFalse($this->processor->supports(\stdClass::class));
    }

    protected function setUp()
    {
        $this->dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->processor = new UserFlushProcessor($this->dispatcher->reveal());
    }
}
