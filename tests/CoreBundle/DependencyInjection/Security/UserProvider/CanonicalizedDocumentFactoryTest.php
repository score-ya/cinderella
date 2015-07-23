<?php

namespace ScoreYa\Cinderella\Bundle\SecurityBundle\Tests\UserProvider;

use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Security\UserProvider\CanonicalizedDocumentFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Security\UserProvider\CanonicalizedDocumentFactory
 */
class CanonicalizedDocumentFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function create()
    {
        $container = new ContainerBuilder();
        $config = ['class' => 'class', 'property' => 'property', 'manager_name' => 'manager_name'];
        $documentFactory = new CanonicalizedDocumentFactory('key', 'provider');

        $documentFactory->create($container, 'test', $config);

        self::assertEquals('score_ya.cinderella.core.util.canonicalizer', (string) $container->getDefinition('test')->getArgument(0));
        self::assertEquals('test.wrapped', (string) $container->getDefinition('test')->getArgument(1));
    }
}
