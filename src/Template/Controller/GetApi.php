<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ScoreYa\Cinderella\Template\TemplateEngine;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class GetApi
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
     * @param string  $name
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke($name, Request $request)
    {
        /** @var User $user */
        $user     = $this->tokenStorage->getToken()->getUser();
        $template = $this->templateRepository->findForApiCall(
            $this->canonicalizer->canonicalize($name),
            $request->getMimeType($request->getRequestFormat(null)),
            $user
        );

        if ($template === null) {
            //overwrite request format to html to return a valid 404 page
            $request->setRequestFormat('html');
            throw new NotFoundHttpException();
        }

        return new Response(
            $this->templateEngine->render($template),
            Response::HTTP_OK,
            ['Content-Type' => $template->getMimeType()]
        );
    }
}
