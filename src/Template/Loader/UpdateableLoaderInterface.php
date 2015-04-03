<?php

namespace ScoreYa\Cinderella\Template\Loader;

use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
interface UpdateableLoaderInterface extends LoaderInterface
{
    /**
     * updates existing template variables
     *
     * @param Template $template A template
     *
     * @return void
     */
    public function update(Template $template);
}
