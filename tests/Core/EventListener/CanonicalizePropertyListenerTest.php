<?php

namespace ScoreYa\Cinderella\Core\Tests\EventListener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Core\Event\CanonicalizableEventObject;
use ScoreYa\Cinderella\Core\EventListener\CanonicalizePropertyListener;
use ScoreYa\Cinderella\Core\Util\Canonicalizer;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\EventListener\CanonicalizePropertyListener
 */
class CanonicalizePropertyListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $canonicalizer;

    /**
     * @var CanonicalizePropertyListener
     */
    private $listener;

    /**
     * @test
     */
    public function canonicalize()
    {
        $event = $this->prophesize(CanonicalizableEventObject::class);

        $event->getCanonicalizableObject()->willReturn(new \stdClass());

        $this->canonicalizer
            ->canonicalizeObjectProperty(Argument::type('stdClass'), 'propertyName', 'canonicalizedPropertyName')
            ->shouldBeCalled();

        $this->listener->canonicalize($event->reveal());
    }

    protected function setUp()
    {
        $this->canonicalizer = $this->prophesize(Canonicalizer::class);

        $this->listener = new CanonicalizePropertyListener(
            $this->canonicalizer->reveal(),
            'propertyName',
            'canonicalizedPropertyName'
        );
    }
}
