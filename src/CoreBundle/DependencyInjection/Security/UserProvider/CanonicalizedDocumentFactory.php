<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Security\UserProvider;

use ScoreYa\Cinderella\Security\UserProvider\CanonicalizedUserProvider;
use Symfony\Bridge\Doctrine\DependencyInjection\Security\UserProvider\EntityFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class CanonicalizedDocumentFactory extends EntityFactory
{
    public function create(ContainerBuilder $container, $id, $config)
    {
        parent::create($container, $id . '.wrapped', $config);

        $container
            ->setDefinition($id, new Definition(CanonicalizedUserProvider::class))
            ->addArgument(new Reference('score_ya.cinderella.core.util.canonicalizer'))
            ->addArgument(new Reference($id . '.wrapped'));
    }
}
