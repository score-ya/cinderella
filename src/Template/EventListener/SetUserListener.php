<?php

namespace ScoreYa\Cinderella\Template\EventListener;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SetUserListener
{
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function onPostDeserialize(ObjectEvent $event)
    {
        /** @var Template $template */
        $template = $event->getObject();

        $template->setUser($this->user);
    }
}
