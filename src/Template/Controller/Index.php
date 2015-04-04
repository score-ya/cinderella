<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use ScoreYa\Cinderella\User\Model\ApiUser;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Index
{
    private $tokenStorage;
    private $templateRepository;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param TemplateRepository    $templateRepository
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        TemplateRepository $templateRepository
    ) {
        $this->tokenStorage       = $tokenStorage;
        $this->templateRepository = $templateRepository;
    }

    /**
     * @return Template[]
     */
    public function __invoke()
    {
        /** @var ApiUser $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->templateRepository->findAllByUser($user);
    }
}
