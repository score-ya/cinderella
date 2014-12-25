<?php

namespace ScoreYa\Cinderella\Bundle\UserBundle;

use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ScoreYaCinderellaUserBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass($this->buildMappingCompilerPass());
    }

    /**
     * @return DoctrineMongoDBMappingsPass
     */
    private function buildMappingCompilerPass()
    {
        $xmlPath = '%kernel.root_dir%/../src/User/Doctrine';
        $namespacePrefix = 'ScoreYa\Cinderella\User\Model';

        return DoctrineMongoDBMappingsPass::createXmlMappingDriver(
            array($xmlPath => $namespacePrefix),
            ['doctrine_mongodb.odm.default_document_manager']
        );
    }
}
