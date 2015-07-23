<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle;

use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler\FlushProcessorPass;
use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Compiler\ValidatorPass;
use ScoreYa\Cinderella\Bundle\CoreBundle\DependencyInjection\Security\UserProvider\CanonicalizedDocumentFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ScoreYaCinderellaCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ValidatorPass());
        $container->addCompilerPass(new FlushProcessorPass());
        /** @var $extension SecurityExtension */
        $extension = $container->getExtension('security');
        $extension->addUserProviderFactory(
            new CanonicalizedDocumentFactory('canonicalized_document', 'doctrine_mongodb.odm.security.user.provider')
        );
    }

}
