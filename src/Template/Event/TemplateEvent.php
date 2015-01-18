<?php

namespace ScoreYa\Cinderella\Template\Event;

use ScoreYa\Cinderella\Core\Event\CanonicalizableEventObject;
use ScoreYa\Cinderella\Template\Model\Template;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class TemplateEvent extends Event implements CanonicalizableEventObject
{
    const CREATED = 'cinderella.template.created';
    const UPDATED = 'cinderella.template.updated';

    private $template;

    /**
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function getCanonicalizableObject()
    {
        return $this->template;
    }
}
