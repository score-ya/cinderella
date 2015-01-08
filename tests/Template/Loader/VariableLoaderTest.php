<?php

namespace ScoreYa\Cinderella\Template\Tests\Loader;

use ScoreYa\Cinderella\Template\Loader\VariableLoader;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\TemplateParser;
use ScoreYa\Cinderella\Template\TemplateParserBuilder;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\Loader\VariableLoader
 */
class VariableLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function load()
    {
        $template      = $this->prophesize(Template::class);
        $parserBuilder = $this->prophesize(TemplateParserBuilder::class);
        $parser        = $this->prophesize(TemplateParser::class);

        $parserBuilder->createByTemplate($template)->willReturn($parser->reveal());

        $parser->parse('content')->willReturn([]);

        $template->getContent()->willReturn('content');

        $this->assertInternalType('array', (new VariableLoader($parserBuilder->reveal()))->load($template->reveal()));
    }
}
