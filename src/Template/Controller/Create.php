<?php

namespace ScoreYa\Cinderella\Template\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Create
{
    private $templateRepository;

    /**
     * @param TemplateRepository $templateRepository
     */
    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    /**
     * @param Template $template
     *
     * @return Response
     */
    public function __invoke(Template $template)
    {
        $this->templateRepository->create($template);

        return new Response(null, Response::HTTP_CREATED);
    }
}
