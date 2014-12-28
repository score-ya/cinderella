<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Sanpi\Behatch\Context\RestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class DefaultContext extends RawMinkContext implements Context, KernelAwareContext
{
    /**
     * @var
     */
    private static $placeholders = array();

    private $fixtues;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RestContext
     */
    protected $restContext;

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel    = $kernel;
        $this->container = $kernel->getContainer();
    }

    public function __construct($fixtures = array())
    {
        $this->fixtues = $fixtures;
    }

    /**
     * @BeforeScenario
     */
    public function prepareContext(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $env */
        $env               = $scope->getEnvironment();
        $this->restContext = $env->getContext(RestContext::class);
    }

    /**
     * @BeforeScenario
     */
    public function loadFixtures()
    {
        if (count($this->fixtues) === 0) {
            return;
        }

        $dm = $this->container->get('doctrine.odm.mongodb.document_manager');
        $dm->getSchemaManager()->dropDatabases();

        $manager = $this->container->get('h4cc_alice_fixtures.manager');
        $objects = $manager->loadFiles($this->fixtues, 'yaml');

        $manager->persist($objects, true);
    }

    /**
     * Replaces placeholders in provided text.
     *
     * @param string $string
     *
     * @return string
     */
    protected function replacePlaceholder($string)
    {
        return str_replace(array_keys(self::$placeholders), self::$placeholders, $string);
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function setPlaceholder($key, $value)
    {
        self::$placeholders[$key] = $value;
    }
}
