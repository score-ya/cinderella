<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('score_ya_cinderella_core');
        $rootNode
            ->children()
                ->arrayNode('canonicalizable')
                    ->canBeUnset()
                    ->prototype('array')
                        ->children()

                            ->scalarNode('event')->cannotBeEmpty()->end()
                            ->scalarNode('class')->cannotBeEmpty()->end()
                            ->scalarNode('property_name')->cannotBeEmpty()->end()
                            ->scalarNode('canonicalized_property_name')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        return $treeBuilder;
    }
}
