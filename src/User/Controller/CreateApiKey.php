<?php

namespace ScoreYa\Cinderella\User\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\User\Model\ApiUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class CreateApiKey
{
    private $tokenStorage;
    private $dm;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param DocumentManager       $dm
     */
    public function __construct(TokenStorageInterface $tokenStorage, DocumentManager $dm)
    {
        $this->tokenStorage = $tokenStorage;
        $this->dm           = $dm;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        /** @var Tenant $tenant */
        $tenant = $this->tokenStorage->getToken()->getUser()->getTenant();

        if ($tenant->getApiUser() !== null) {
            throw new ConflictHttpException('Api key is already created.');
        }

        $apiUser = new ApiUser();

        $tenant->setApiUser($apiUser);
        $apiUser->setTenant($tenant);

        $this->dm->persist($apiUser);

        $this->dm->flush();

        return new Response(null, Response::HTTP_CREATED);
    }
}
