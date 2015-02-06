<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Get
{
    /**
     * @param Template $template
     *
     * @return Template
     */
    public function __invoke(Template $template)
    {
        return $template;
    }
}
