<?php

namespace ScoreYa\Cinderella\Template\Controller\Template;

use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use ScoreYa\Cinderella\User\Model\ApiUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Get
{
    private $tokenStorage;
    private $templateRepository;
    private $canonicalizer;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param TemplateRepository    $templateRepository
     * @param Canonicalizer         $canonicalizer
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        TemplateRepository $templateRepository,
        Canonicalizer $canonicalizer
    ) {
        $this->tokenStorage       = $tokenStorage;
        $this->templateRepository = $templateRepository;
        $this->canonicalizer      = $canonicalizer;
    }

    /**
     * @param string $name
     *
     * @return Response
     */
    public function __invoke($name)
    {
        /** @var ApiUser $user */
        $user     = $this->tokenStorage->getToken()->getUser();
        $template = $this->templateRepository->findByCanonicalName(
            $this->canonicalizer->canonicalize($name),
            $user->getTenant()
        );

        return new Response($template->getContent(), Response::HTTP_OK, ['Content-Type' => $template->getMimeType()]);
    }
}
