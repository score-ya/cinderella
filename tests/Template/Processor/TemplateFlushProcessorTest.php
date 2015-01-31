<?php

namespace ScoreYa\Cinderella\Template\Tests\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Template\Event\TemplateEvent;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\Processor\TemplateFlushProcessor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\Processor\TemplateFlushProcessor<extended>
 */
class TemplateFlushProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TemplateFlushProcessor
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
        $template = $this->prophesize(Template::class);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $uow->getDocumentChangeSet($template)->willReturn(['id' => [null, 'id']]);
        $uow->getDocumentState($template)->willReturn(UnitOfWork::STATE_MANAGED);

        $this->dispatcher->dispatch('cinderella.template.created', Argument::type(TemplateEvent::class))->shouldBeCalled();

        $this->processor->process($dm->reveal(), $template->reveal());
    }

    /**
     * @test
     */
    public function processChangedObject()
    {
        $dm = $this->prophesize(DocumentManager::class);
        $uow = $this->prophesize(UnitOfWork::class);
        $template = $this->prophesize(Template::class);

        $dm->getUnitOfWork()->willReturn($uow->reveal());

        $uow->getDocumentChangeSet($template)->willReturn(['id' => ['id', 'id']]);
        $uow->getDocumentState($template)->willReturn(UnitOfWork::STATE_MANAGED);

        $this->dispatcher->dispatch('cinderella.template.updated', Argument::type(TemplateEvent::class))->shouldBeCalled();

        $this->processor->process($dm->reveal(), $template->reveal());
    }

    /**
     * @test
     */
    public function supports()
    {
        $this->assertTrue($this->processor->supports(Template::class));
        $this->assertFalse($this->processor->supports(\stdClass::class));
    }

    protected function setUp()
    {
        $this->dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->processor = new TemplateFlushProcessor($this->dispatcher->reveal());
    }
}
