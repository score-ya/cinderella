<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\EventListener;

use Prophecy\Argument;
use ScoreYa\Cinderella\Bundle\CoreBundle\EventListener\ParamConverterListener;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\EventListener\ParamConverterListener
 */
class ParamConverterListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkViolation()
    {
        $listener            = new ParamConverterListener();
        $event               = $this->prophesize(FilterControllerEvent::class);
        $request             = $this->prophesize(Request::class);
        $attributes          = $this->prophesize(ParameterBagInterface::class);
        $request->attributes = $attributes->reveal();

        $data = [
            'test' => ['name' => 'dummy'],
        ];

        $attributes->get('_converters')->willReturn($data);
        $attributes->set('_converters', Argument::that(function ($arg) {
            return $arg['test'] instanceof ParamConverter;
        }))->shouldBeCalled();

        $event->getRequest()->willReturn($request->reveal());

        $listener->onKernelController($event->reveal());
    }
}
