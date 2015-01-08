<?php

namespace ScoreYa\Cinderella\Template;

use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TemplateParserBuilder
{
    /**
     * @param Template $template
     *
     * @return TemplateParser
     */
    public function createByTemplate(Template $template)
    {
        return new TemplateParser($template->getOpeningVariable(), $template->getClosingVariable());
    }
}
