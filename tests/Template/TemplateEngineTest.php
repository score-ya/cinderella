<?php

namespace ScoreYa\Cinderella\Template\Tests;

use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Template\Loader\LoaderInterface;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\TemplateEngine;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\TemplateEngine
 */
class TemplateEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TemplateEngine
     */
    private $engine;

    /**
     * @var ObjectProphecy
     */
    private $loader;

    /**
     * @var ObjectProphecy
     */
    private $query;

    /**
     * @test
     */
    public function ignoreUnusedVariables()
    {
        $template = $this->prophesize(Template::class);

        $template->getContent()->willReturn('{{test}}');

        $this->query->has('test')->willReturn(false);

        $this->loader->load($template)->willReturn(['{{test}}' => 'test']);

        $this->assertEquals('{{test}}', $this->engine->render($template->reveal()));
    }

    /**
     * @test
     */
    public function replaceUsedVariables()
    {
        $template = $this->prophesize(Template::class);

        $template->getContent()->willReturn('{{test}}{{other}}');

        $this->query->has('test')->willReturn(true);
        $this->query->get('test')->willReturn('other');

        $this->loader->load($template)->willReturn(['{{test}}' => 'test']);

        $this->assertEquals('other{{other}}', $this->engine->render($template->reveal()));
    }

    /**
     * @test
     */
    public function doNothingIfNoVariables()
    {
        $template = $this->prophesize(Template::class);

        $template->getContent()->willReturn('{{test}}');

        $this->loader->load($template)->willReturn([]);

        $this->assertEquals('{{test}}', $this->engine->render($template->reveal()));
    }

    protected function setUp()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $request      = $this->prophesize(Request::class);
        $this->query  = $this->prophesize(ParameterBagInterface::class);
        $this->loader = $this->prophesize(LoaderInterface::class);
        $this->engine = new TemplateEngine($this->loader->reveal(), $requestStack->reveal());

        $request->query = $this->query->reveal();

        $requestStack->getCurrentRequest()->willReturn($request->reveal());
    }
}
