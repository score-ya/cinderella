<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\EventListener;

use Prophecy\Argument;
use ScoreYa\Cinderella\Bundle\CoreBundle\EventListener\ViolationsListener;
use ScoreYa\Cinderella\Core\Controller\Violations;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\EventListener\ViolationsListener
 */
class ViolationsListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkViolation()
    {
        $listener            = new ViolationsListener('test');
        $event               = $this->prophesize(FilterControllerEvent::class);
        $request             = $this->prophesize(Request::class);
        $attributes          = $this->prophesize(ParameterBagInterface::class);
        $violations          = $this->prophesize(ConstraintViolationListInterface::class);
        $request->attributes = $attributes->reveal();

        $violations->count()->willReturn(1);

        $attributes->get('test')->willReturn($violations->reveal());
        $attributes->set('_view', Argument::which('getStatusCode', 400))->shouldBeCalled();

        $event->getRequest()->willReturn($request->reveal());
        $event->setController(Argument::type(Violations::class))->shouldBeCalled();

        $listener->checkViolation($event->reveal());
    }
}
