<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class ScoreYaCinderellaCoreExtension extends ConfigurableExtension
{
    use ServiceLoadExtensionTrait;

    /**
     * Configures the passed container according to the merged configuration.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $this->loadServices($container, __DIR__);

        $this->createCanonicalizePropertyListener($mergedConfig, $container);
        $this->createCanonicalInitializer($mergedConfig, $container);
    }

    /**
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    private function createCanonicalizePropertyListener(array $mergedConfig, ContainerBuilder $container)
    {
        if (!isset($mergedConfig['canonicalizable']) || count($mergedConfig['canonicalizable']) === 0) {
            return;
        }

        $parentId = "score_ya.cinderella.core.event_listener.canonicalize_property";

        foreach ($mergedConfig['canonicalizable'] as $canonicalizable) {
            $definition = new DefinitionDecorator($parentId);
            $definition
                ->addArgument($canonicalizable['property_name'])
                ->addArgument($canonicalizable['canonicalized_property_name'])
                ->addTag('kernel.event_listener', ['event' => $canonicalizable['event'], 'method' => 'canonicalize']);

            $container->setDefinition(
                $parentId.'.'.$canonicalizable['event'].'.'.$canonicalizable['property_name'],
                $definition
            );
        }
    }

    /**
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    private function createCanonicalInitializer(array $mergedConfig, ContainerBuilder $container)
    {
        if (!isset($mergedConfig['canonicalizable']) || count($mergedConfig['canonicalizable']) === 0) {
            return;
        }

        $parentId = "score_ya.cinderella.core.validator.canonical_initializer";

        foreach ($mergedConfig['canonicalizable'] as $canonicalizable) {
            $definition = new DefinitionDecorator($parentId);
            $definition
                ->addArgument($canonicalizable['class'])
                ->addArgument($canonicalizable['property_name'])
                ->addArgument($canonicalizable['canonicalized_property_name'])
                ->addTag('validator.initializer')
                ;

            $container->setDefinition(
                $parentId.'.'.$canonicalizable['event'].'.'.$canonicalizable['property_name'],
                $definition
            );
        }
    }
}
