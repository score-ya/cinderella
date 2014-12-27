<?php

namespace ScoreYa\Cinderella\Multitenancy\Tests\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Multitenancy\Event\TenantEvent;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\Multitenancy\Processor\TenantFlushProcessor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Multitenancy\Processor\TenantFlushProcessor
 */
class TenantFlushProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TenantFlushProcessor
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
        $tenant = $this->prophesize(Tenant::class);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $uow->getDocumentChangeSet($tenant)->willReturn([]);
        $uow->getDocumentState($tenant)->willReturn(UnitOfWork::STATE_MANAGED);

        $this->dispatcher->dispatch('cinderella.tenant.created', Argument::type(TenantEvent::class))->shouldBeCalled();

        $this->processor->process($dm->reveal(), $tenant->reveal());
    }

    /**
     * @test
     */
    public function supports()
    {
        $this->assertTrue($this->processor->supports(Tenant::class));
        $this->assertFalse($this->processor->supports(\stdClass::class));
    }

    protected function setUp()
    {
        $this->dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->processor = new TenantFlushProcessor($this->dispatcher->reveal());
    }
}
