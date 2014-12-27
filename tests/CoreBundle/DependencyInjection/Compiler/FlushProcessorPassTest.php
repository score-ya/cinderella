<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler\FlushProcessorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler\FlushProcessorPass
 */
class FlushProcessorPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function addFlushProcessors()
    {
        $flushListener = new Definition();

        $this->setDefinition('score_ya.cinderella.core.event_lister.document_flush', $flushListener);

        $flushProcessor = new Definition();
        $flushProcessor->addTag('cinderella.flush_processor');

        $this->setDefinition('processor', $flushProcessor);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'score_ya.cinderella.core.event_lister.document_flush',
            'addProcessor',
            [new Reference('processor')]
        );
    }

    /**
     * Register the compiler pass under test, just like you would do inside a bundle's load()
     * method:
     *
     *   $container->addCompilerPass(new MyCompilerPass());
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FlushProcessorPass());
    }
}
