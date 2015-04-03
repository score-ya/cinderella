<?php

namespace ScoreYa\Cinderella\Security\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class AddApiToken
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data['data'] = ['apiKey' => $user->getApiUser()->getApiKey()];

        $event->setData($data);
    }
}
