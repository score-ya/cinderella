<?php

namespace ScoreYa\Cinderella\Bundle\SecurityBundle;

use ScoreYa\Cinderella\Bundle\SecurityBundle\UserProvider\CanonicalizedDocumentFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ScoreYaCinderellaSecurityBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        /** @var $extension SecurityExtension */
        $extension = $container->getExtension('security');
        $extension->addUserProviderFactory(
            new CanonicalizedDocumentFactory('canonicalized_document', 'doctrine_mongodb.odm.security.user.provider')
        );
    }
}
