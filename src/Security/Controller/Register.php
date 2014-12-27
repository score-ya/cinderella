<?php

namespace ScoreYa\Cinderella\Security\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Register
{
    private $dm;

    /**
     * @param ObjectManager $dm
     */
    public function __construct(ObjectManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @param Tenant $tenant
     * @param User   $user
     *
     * @return Response
     */
    public function __invoke(Tenant $tenant, User $user)
    {
        $this->dm->persist($tenant);

        $user->setTenant($tenant);
        $this->dm->persist($user);

        $this->dm->flush();

        return new Response(null, 201);
    }
}
