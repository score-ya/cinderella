<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sanpi\Behatch\Context\RestContext;
use Sanpi\Behatch\HttpCall\HttpCallResultPool;
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

    private $fixtures;

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
     * @var HttpCallResultPool
     */
    protected $resultPool;

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel    = $kernel;
        $this->container = $kernel->getContainer();
    }

    public function __construct(HttpCallResultPool $resultPool, $fixtures = array())
    {
        $this->resultPool = $resultPool;
        $this->fixtures   = $fixtures;
    }

    /**
     * @param BeforeScenarioScope $scope
     *
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
        if (count($this->fixtures) === 0) {
            return;
        }

        $this->getDocumentManager()->getSchemaManager()->dropDatabases();

        $manager = $this->container->get('h4cc_alice_fixtures.manager');
        $objects = $manager->loadFiles($this->fixtures, 'yaml');

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

    /**
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->container->get('doctrine.odm.mongodb.document_manager');
    }
}
