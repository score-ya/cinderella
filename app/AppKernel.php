<?php

namespace ScoreYa\Cinderella\App;

use Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle;
use Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle;
use FOS\RestBundle\FOSRestBundle;
use Gfreeau\Bundle\GetJWTBundle\GfreeauGetJWTBundle;
use h4cc\AliceFixturesBundle\h4ccAliceFixturesBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle;
use ScoreYa\Cinderella\Bundle\CoreBundle\ScoreYaCinderellaCoreBundle;
use ScoreYa\Cinderella\Bundle\SDKBundle\ScoreYaCinderellaSDKBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class AppKernel extends Kernel
{

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new MonologBundle(),
            new SwiftmailerBundle(),
            new DoctrineMongoDBBundle(),
            new DoctrineCacheBundle(),
            new SensioFrameworkExtraBundle(),
            new FOSRestBundle(),
            new JMSSerializerBundle(),
            new LexikJWTAuthenticationBundle(),
            new GfreeauGetJWTBundle(),
            new ScoreYaCinderellaCoreBundle(),
            new ScoreYaCinderellaSDKBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test', 'dev_system'], true)) {
            $bundles[] = new DebugBundle();
            $bundles[] = new WebProfilerBundle();
        }

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new h4ccAliceFixturesBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->rootDir.'/../var/cache/'.$this->environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->rootDir.'/../var/logs';
    }
}
