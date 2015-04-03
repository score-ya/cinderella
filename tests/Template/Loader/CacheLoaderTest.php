<?php

namespace ScoreYa\Cinderella\Template\Tests\Loader;

use Doctrine\Common\Cache\Cache;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Template\Loader\CacheLoader;
use ScoreYa\Cinderella\Template\Loader\LoaderInterface;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\Loader\CacheLoader
 */
class CacheLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheLoader
     */
    private $loader;

    /**
     * @var ObjectProphecy
     */
    private $concreteLoader;

    /**
     * @var ObjectProphecy
     */
    private $cache;

    /**
     * @test
     */
    public function hitCacheIfCacheIsSet()
    {
        $template = $this->getTemplate();

        $this->cache->contains('template_id')->willReturn(true);
        $this->cache->fetch('template_id')->willReturn([]);

        self::assertInternalType('array', $this->loader->load($template->reveal()));
    }

    /**
     * @test
     */
    public function setCacheIfIsNotSet()
    {
        $template = $this->getTemplate();

        $this->cache->contains('template_id')->willReturn(false);
        $this->cache->save('template_id', [])->shouldBeCalled();

        $this->concreteLoader->load($template)->willReturn([]);

        self::assertInternalType('array', $this->loader->load($template->reveal()));
    }

    /**
     * @test
     */
    public function updateCache()
    {
        $template = $this->getTemplate();

        $this->cache->contains('template_id')->willReturn(false);
        $this->cache->save('template_id', [])->shouldBeCalled();
        $this->cache->delete('template_id')->shouldBeCalled();

        $this->concreteLoader->load($template)->willReturn([]);

        $this->loader->update($template->reveal());
    }

    /**
     * @return ObjectProphecy
     */
    private function getTemplate()
    {
        $template = $this->prophesize(Template::class);
        $template->getId()->willReturn('template_id');

        return $template;
    }

    protected function setUp()
    {
        $this->concreteLoader = $this->prophesize(LoaderInterface::class);
        $this->cache = $this->prophesize(Cache::class);
        $this->loader = new CacheLoader($this->concreteLoader->reveal(), $this->cache->reveal());
    }
}
