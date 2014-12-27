<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler\ValidatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler\ValidatorPass
 */
class ValidatorPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function registerXMLMappings()
    {
        $validatorBuilder = new Definition();
        $this->setDefinition('validator.builder', $validatorBuilder);
        $this->setParameter('app.root_dir', __DIR__.'/../../Fixtures');

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'validator.builder',
            'addXmlMappings',
            [[realpath(__DIR__.'/../../Fixtures/src/Test/Validator/test.xml')]]
        );
    }

    /**
     * Register the compiler pass under test, just like you would do inside a bundle's load()
     * method:
     *
     *   $container->addCompilerPass(new MyCompilerPass());
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ValidatorPass());
    }
}
