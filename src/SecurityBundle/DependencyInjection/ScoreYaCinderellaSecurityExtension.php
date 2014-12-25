<?php

namespace ScoreYa\Cinderella\Bundle\SecurityBundle\DependencyInjection;

use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\ServiceLoadExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ScoreYaCinderellaSecurityExtension extends Extension
{
    use ServiceLoadExtensionTrait;

    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->loadServices($container, __DIR__);
    }
}
