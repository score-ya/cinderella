<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use ScoreYa\Cinderella\User\Model\ApiUser;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ScoreYa\Cinderella\Template\TemplateEngine;

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
    private $templateEngine;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param TemplateRepository    $templateRepository
     * @param Canonicalizer         $canonicalizer
     * @param TemplateEngine        $templateEngine
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        TemplateRepository $templateRepository,
        Canonicalizer $canonicalizer,
        TemplateEngine $templateEngine
    ) {
        $this->tokenStorage       = $tokenStorage;
        $this->templateRepository = $templateRepository;
        $this->canonicalizer      = $canonicalizer;
        $this->templateEngine     = $templateEngine;
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

        if ($user instanceof User) {
            return $template;
        }

        return new Response($this->templateEngine->render($template), Response::HTTP_OK, ['Content-Type' => $template->getMimeType()]);
    }
}
