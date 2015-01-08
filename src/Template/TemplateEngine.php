<?php

namespace ScoreYa\Cinderella\Template;

use ScoreYa\Cinderella\Template\Loader\LoaderInterface;
use ScoreYa\Cinderella\Template\Model\Template;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TemplateEngine
{
    private $loader;
    private $requestStack;

    /**
     * @param LoaderInterface $loader
     * @param RequestStack    $requestStack
     */
    public function __construct(LoaderInterface $loader, RequestStack $requestStack)
    {
        $this->loader       = $loader;
        $this->requestStack = $requestStack;
    }

    /**
     * @param Template $template
     *
     * @return string
     */
    public function render(Template $template)
    {
        $variables = $this->loader->load($template);
        $request   = $this->requestStack->getCurrentRequest();

        foreach ($variables as $key => $variable) {
            unset($variables[$key]);
            if ($request->query->has($variable)) {
                $variables[$key] = $request->query->get($variable);
            }
        }

        return str_replace(array_keys($variables), $variables, $template->getContent());
    }
}
