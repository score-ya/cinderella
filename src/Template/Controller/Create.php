<?php

namespace ScoreYa\Cinderella\Template\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Template\Model\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Create
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
     * @param Template $template
     *
     * @return Response
     */
    public function __invoke(Template $template)
    {
        $template->setTenant($this->tokenStorage->getToken()->getUser()->getTenant());

        $this->dm->persist($template);

        $this->dm->flush();

        return new Response(null, Response::HTTP_CREATED);
    }
}
