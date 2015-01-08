<?php

namespace ScoreYa\Cinderella\Template\Tests;

use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\TemplateParser;
use ScoreYa\Cinderella\Template\TemplateParserBuilder;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\TemplateParserBuilder
 */
class TemplateParserBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createByTemplate()
    {
        $template = $this->prophesize(Template::class);

        $this->assertInstanceOf(
            TemplateParser::class,
            (new TemplateParserBuilder())->createByTemplate($template->reveal())
        );
    }
}
