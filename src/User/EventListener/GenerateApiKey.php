<?php

namespace ScoreYa\Cinderella\User\EventListener;

use ScoreYa\Cinderella\User\Event\UserEvent;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class GenerateApiKey
{
    private $hashGenerator;

    /**
     * @param SecureRandomInterface $hashGenerator
     */
    public function __construct(SecureRandomInterface $hashGenerator)
    {
        $this->hashGenerator = $hashGenerator;
    }

    /**
     * @param UserEvent $event
     */
    public function onUserCreated(UserEvent $event)
    {
        if ($event->getUser()->getApiUser()->getApiKey() !== null) {
            return;
        }

        $event->getUser()->getApiUser()->setApiKey(rtrim(strtr(base64_encode($this->hashGenerator->nextBytes(32)), '+/', '-_'), '='));
    }
}
