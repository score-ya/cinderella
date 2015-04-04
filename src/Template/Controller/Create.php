<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Create
{
    private $templateRepository;
    private $urlGenerator;

    /**
     * @param TemplateRepository $templateRepository
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(TemplateRepository $templateRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->templateRepository = $templateRepository;
        $this->urlGenerator       = $urlGenerator;
    }

    /**
     * @param Template $template
     *
     * @return Response
     */
    public function __invoke(Template $template)
    {
        $this->templateRepository->create($template);

        return new Response(
            null,
            Response::HTTP_CREATED,
            [
                'Location' => $this->urlGenerator->generate(
                    'score_ya_cinderella_template_get',
                    ['id' => $template->getId()]
                )
            ]
        );
    }
}
