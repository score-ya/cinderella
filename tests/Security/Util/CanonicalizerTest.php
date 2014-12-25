<?php

namespace ScoreYa\Cinderella\Security\Tests\Util;

use ScoreYa\Cinderella\Security\Util\Canonicalizer;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Security\Util\Canonicalizer
 */
class CanonicalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed  $expected
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
            ['testtest','TestTest'],
            ['test-test','Test-Test'],
            ['test_test','Test_Test'],
        ];
    }
}
