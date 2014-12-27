<?php

namespace ScoreYa\Cinderella\Core\Tests\Serializer\EventListener;

use JMS\Serializer\JsonSerializationVisitor;
use ScoreYa\Cinderella\Core\Serializer\Handler\ConstraintViolationHandler;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\Serializer\Handler\ConstraintViolationHandler
 */
class ConstraintViolationHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function serializeViolationToJson()
    {
        $visitor   = $this->prophesize(JsonSerializationVisitor::class);
        $violation = $this->prophesize(ConstraintViolation::class);

        $data = ['propertyPath' => 'property', 'message' => 'message'];

        $violation->getPropertyPath()->willReturn('property');
        $violation->getMessage()->willReturn('message');

        $visitor->getRoot()->willReturn(null);
        $visitor->setRoot($data)->shouldBeCalled();

        $handler = new ConstraintViolationHandler();

        $this->assertEquals($data, $handler->serializeViolationToJson($visitor->reveal(), $violation->reveal(), []));
    }
}
