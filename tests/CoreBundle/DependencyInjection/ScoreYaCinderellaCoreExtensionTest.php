<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\ScoreYaCinderellaCoreExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\ScoreYaCinderellaCoreExtension
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\ServiceLoadExtensionTrait
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Configuration
 */
class ScoreYaCinderellaCoreExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function afterLoadWithoutConfigNoTagsAreRegistered()
    {
        $this->load();

        $this->assertCount(0, $this->container->findTaggedServiceIds('validator.initializer'));
    }

    /**
     * @test
     */
    public function afterLoadingWithCanonicalizableConfig()
    {
        $this->load(
            [
                'canonicalizable' => [
                    [
                        'class'                       => '\stdClass',
                        'event'                       => 'cinderella.test',
                        'property_name'               => 'propertyName',
                        'canonicalized_property_name' => 'canonicalizedPropertyName',
                    ],
                ],
            ]
        );

        $this->assertContainerBuilderHasServiceDefinitionWithParent(
            'score_ya.cinderella.core.validator.canonical_initializer.cinderella.test.propertyName',
            'score_ya.cinderella.core.validator.canonical_initializer'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'score_ya.cinderella.core.validator.canonical_initializer.cinderella.test.propertyName',
            'validator.initializer'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'score_ya.cinderella.core.validator.canonical_initializer.cinderella.test.propertyName',
            0,
            '\stdClass'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'score_ya.cinderella.core.validator.canonical_initializer.cinderella.test.propertyName',
            1,
            'propertyName'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'score_ya.cinderella.core.validator.canonical_initializer.cinderella.test.propertyName',
            2,
            'canonicalizedPropertyName'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithParent(
            'score_ya.cinderella.core.event_listener.canonicalize_property.cinderella.test.propertyName',
            'score_ya.cinderella.core.event_listener.canonicalize_property'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'score_ya.cinderella.core.event_listener.canonicalize_property.cinderella.test.propertyName',
            'kernel.event_listener',
            ['event' => 'cinderella.test', 'method' => 'canonicalize']
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'score_ya.cinderella.core.event_listener.canonicalize_property.cinderella.test.propertyName',
            0,
            'propertyName'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'score_ya.cinderella.core.event_listener.canonicalize_property.cinderella.test.propertyName',
            1,
            'canonicalizedPropertyName'
        );
    }

    /**
     * Return an array of container extensions you need to be registered for each test (usually just the container
     * extension you are testing.
     *
     * @return ExtensionInterface[]
     */
    protected function getContainerExtensions()
    {
        return [new ScoreYaCinderellaCoreExtension()];
    }
}
