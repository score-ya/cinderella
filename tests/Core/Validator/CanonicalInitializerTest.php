<?php

namespace ScoreYa\Cinderella\Core\Tests\Validator;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use ScoreYa\Cinderella\Core\Validator\CanonicalInitializer;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\Validator\CanonicalInitializer
 */
class CanonicalInitializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $canonicalizer;

    /**
     * @var CanonicalInitializer
     */
    private $initializer;

    /**
     * @test
     */
    public function canonicalize()
    {
        $this->canonicalizer
            ->canonicalizeObjectProperty(Argument::type('stdClass'), 'propertyName', 'canonicalizedPropertyName')
            ->shouldBeCalled();

        $this->initializer->initialize(new \stdClass());
    }

    /**
     * @test
     */
    public function canonicalizeWithWrongObject()
    {
        $this->canonicalizer
            ->canonicalizeObjectProperty()
            ->shouldNotBeCalled();

        $this->initializer->initialize('dummy');
    }

    protected function setUp()
    {
        $this->canonicalizer = $this->prophesize(Canonicalizer::class);

        $this->initializer = new CanonicalInitializer(
            $this->canonicalizer->reveal(),
            '\stdClass',
            'propertyName',
            'canonicalizedPropertyName'
        );
    }
}
