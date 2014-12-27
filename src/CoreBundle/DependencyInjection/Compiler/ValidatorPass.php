<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class ValidatorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('validator.builder')) {
            return;
        }

        $validatorBuilder = $container->findDefinition('validator.builder');
        $appDir = $container->getParameterBag()->resolveValue('%app.root_dir%');
        $validatorFiles = array();
        $finder = new Finder();

        foreach ($finder->files()->in($appDir.'/src/*/Validator')->name('*.xml') as $file) {
            $validatorFiles[] = $file->getRealPath();
        }

        $validatorBuilder->addMethodCall('addXmlMappings', array($validatorFiles));
    }
}
