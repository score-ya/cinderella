<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class FlushProcessorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('score_ya.cinderella.core.event_lister.document_flush')) {
            return;
        }

        $flushListener = $container->findDefinition('score_ya.cinderella.core.event_lister.document_flush');

        foreach ($container->findTaggedServiceIds('cinderella.flush_processor') as $id => $args) {
            $flushListener->addMethodCall('addProcessor', [new Reference($id)]);
        }
    }
}
