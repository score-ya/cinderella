<?php

namespace ScoreYa\Cinderella\User\EventListener;

use ScoreYa\Cinderella\User\Event\ApiUserEvent;
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
     * @param ApiUserEvent $event
     */
    public function onApiUserCreated(ApiUserEvent $event)
    {
        $event->getApiUser()->setApiKey(rtrim(strtr(base64_encode($this->hashGenerator->nextBytes(32)), '+/', '-_'), '='));
    }
}
