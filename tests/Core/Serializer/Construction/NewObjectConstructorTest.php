<?php

namespace ScoreYa\Cinderella\Core\Tests\Serializer\Construction;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\VisitorInterface;
use ScoreYa\Cinderella\Core\Serializer\Construction\NewObjectConstructor;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\Serializer\Construction\NewObjectConstructor
 */
class NewObjectConstructorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function construct()
    {
        $constructor = new NewObjectConstructor();

        $visitor = $this->prophesize(VisitorInterface::class);
        $metadata = $this->prophesize(ClassMetadata::class)->reveal();
        $metadata->name = \stdClass::class;
        $context = $this->prophesize(DeserializationContext::class);

        $this->assertInstanceOf(\stdClass::class, $constructor->construct($visitor->reveal(), $metadata, [], [], $context->reveal()));
    }
}
