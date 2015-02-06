<?php

namespace ScoreYa\Cinderella\Template\Loader;

use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
interface LoaderInterface
{
    /**
     * Loads the template variables.
     *
     * @param Template $template A template
     *
     * @return array
     */
    public function load(Template $template);
}
