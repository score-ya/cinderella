<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\Repository\TemplateRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Delete
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
     * @return Template
     */
    public function __invoke(Template $template)
    {
        $this->templateRepository->delete($template);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
