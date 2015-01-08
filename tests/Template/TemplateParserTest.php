<?php

namespace ScoreYa\Cinderella\Template\Tests;

use ScoreYa\Cinderella\Template\TemplateParser;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\TemplateParser
 */
class TemplateParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RunTimeException
     * @expectedExceptionMessage Expected a variable after opening.
     * @test
     */
    public function parseEmptyString()
    {
        $dummy = new TemplateParser('{{', '}}');

        $dummy->parse("Lorem ipsum {{}} dolor sit amet");
    }

    /**
     * @expectedException \RunTimeException
     * @expectedExceptionMessage Expected closing after variable name.
     * @test
     */
    public function parseMissingClosing()
    {
        $dummy = new TemplateParser('{{', '}}');

        $dummy->parse("Lorem ipsum dolor sit amet {{test");
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage "dolor test" is not a valid template variable.
     * @test
     */
    public function parseInvalidVariable()
    {
        $dummy = new TemplateParser('{{', '}}');

        $dummy->parse("Lorem ipsum {{dolor test}} sit amet");
    }

    /**
     * @param string $opener
     * @param string $closer
     *
     * @dataProvider getOpenerAndCloserVariants
     * @test
     */
    public function parse($opener, $closer)
    {
        $dummy = new TemplateParser($opener, $closer);

        $result = $dummy->parse("Lorem ipsum ".$opener." dolor ".$closer." sit amet, \n consetetur ".$opener."sadipscing".$closer." elitr, sed diam");
        $this->assertCount(2, $result);

        $this->assertArrayHasKey($opener.' dolor '.$closer, $result);
        $this->assertEquals('dolor', $result[$opener.' dolor '.$closer]);
        $this->assertArrayHasKey($opener.'sadipscing'.$closer, $result);
        $this->assertEquals('sadipscing', $result[$opener.'sadipscing'.$closer]);
    }

    /**
     * @return array
     */
    public function getOpenerAndCloserVariants()
    {
        return [
            ['{{', '}}'],
            ['?!', '!?']
        ];
    }
}
