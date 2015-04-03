<?php

namespace ScoreYa\Cinderella\User\EventListener;

use ScoreYa\Cinderella\User\Event\UserEvent;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SetPassword
{
    private $passwordEncoder;

    /**
     * @param PasswordEncoderInterface $passwordEncoder
     *
     */
    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param UserEvent $event
     */
    public function onUserCreated(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setPassword($this->passwordEncoder->encodePassword($user->getPlainPassword(), null));
    }
}
