<?php

namespace ScoreYa\Cinderella\User\Tests\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\User\Event\ApiUserEvent;
use ScoreYa\Cinderella\User\Model\ApiUser;
use ScoreYa\Cinderella\User\Processor\ApiUserFlushProcessor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\User\Processor\ApiUserFlushProcessor
 */
class ApiUserFlushProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiUserFlushProcessor
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
        $user = $this->prophesize(ApiUser::class);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $uow->getDocumentChangeSet($user)->willReturn([]);
        $uow->getDocumentState($user)->willReturn(UnitOfWork::STATE_MANAGED);

        $this->dispatcher->dispatch('cinderella.api_user.created', Argument::type(ApiUserEvent::class))->shouldBeCalled();

        $this->processor->process($dm->reveal(), $user->reveal());
    }

    /**
     * @test
     */
    public function supports()
    {
        $this->assertTrue($this->processor->supports(ApiUser::class));
        $this->assertFalse($this->processor->supports(\stdClass::class));
    }

    protected function setUp()
    {
        $this->dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->processor = new ApiUserFlushProcessor($this->dispatcher->reveal());
    }
}
