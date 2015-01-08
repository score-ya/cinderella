<?php

namespace ScoreYa\Cinderella\Template\Loader;

use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\Template\TemplateParserBuilder;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class VariableLoader implements LoaderInterface
{
    private $templateParserBuilder;

    /**
     * @param TemplateParserBuilder $templateParserBuilder
     */
    public function __construct(TemplateParserBuilder $templateParserBuilder)
    {
        $this->templateParserBuilder = $templateParserBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function load(Template $template)
    {
        return $this->templateParserBuilder->createByTemplate($template)->parse($template->getContent());
    }
}
