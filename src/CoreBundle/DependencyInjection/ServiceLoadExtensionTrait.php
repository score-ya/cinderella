<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
trait ServiceLoadExtensionTrait
{
    /**
     * @param ContainerBuilder $container
     * @param string           $path
     */
    protected function loadServices(ContainerBuilder $container, $path)
    {
        $servicesPath = $path . '/../Resources/config/services';
        $loader       = new XmlFileLoader($container, new FileLocator($servicesPath));
        $finder       = new Finder();

        /** @var $file SplFileInfo */
        foreach ($finder->in($servicesPath)->files()->name('*.xml') as $file) {
            $loader->load($file->getFilename());
        }
    }
}
