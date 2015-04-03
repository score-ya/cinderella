<?php

namespace ScoreYa\Cinderella\Template\Loader;

use Doctrine\Common\Cache\Cache;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class CacheLoader implements UpdateableLoaderInterface
{
    private $loader;
    private $cache;

    public function __construct(LoaderInterface $loader, Cache $cache)
    {
        $this->loader = $loader;
        $this->cache  = $cache;
    }

    /**
     * Loads the template variables.
     *
     * @param Template $template A template
     *
     * @return array
     */
    public function load(Template $template)
    {
        if ($this->cache->contains($template->getId())) {
            return $this->cache->fetch($template->getId());
        }

        $variables = $this->loader->load($template);

        $this->cache->save($template->getId(), $variables);

        return $variables;
    }

    /**
     * updates existing template variables
     *
     * @param Template $template A template
     */
    public function update(Template $template)
    {
        $this->cache->delete($template->getId());
        $this->load($template);
    }
}
