<?php

namespace ScoreYa\Cinderella\Core\Tests\Util;

use ScoreYa\Cinderella\Core\Util\Canonicalizer;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Core\Util\Canonicalizer
 */
class CanonicalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider getData
     * @test
     */
    public function canonicalize($expected, $string)
    {
        $canonicalizer = new Canonicalizer();

        $this->assertEquals($expected, $canonicalizer->canonicalize($string));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [null, null],
            ['testtest', 'TestTest'],
            ['test-test', 'Test-Test'],
            ['test_test', 'Test_Test'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider getData
     * @test
     */
    public function canonicalizeObjectProperty($expected, $string)
    {
        $canonicalizer = new Canonicalizer();

        $object                            = new \stdClass();
        $object->propertyName              = $string;
        $object->canonicalizedPropertyName = null;
        $canonicalizer->canonicalizeObjectProperty($object, 'propertyName', 'canonicalizedPropertyName');
        $this->assertEquals($expected, $object->canonicalizedPropertyName);
    }
}
