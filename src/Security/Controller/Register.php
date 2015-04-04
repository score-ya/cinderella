<?php

namespace ScoreYa\Cinderella\Security\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use ScoreYa\Cinderella\User\Model\ApiUser;
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
     * @param User $user
     *
     * @return Response
     */
    public function __invoke(User $user)
    {
        $apiUser = new ApiUser();

        $this->dm->persist($apiUser);

        $user->setApiUser($apiUser);

        $this->dm->persist($user);

        $this->dm->flush();

        return new Response(null, Response::HTTP_CREATED);
    }
}
