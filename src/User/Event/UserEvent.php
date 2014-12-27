<?php

namespace ScoreYa\Cinderella\User\Event;

use ScoreYa\Cinderella\Core\Event\CanonicalizableEventObject;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class UserEvent extends Event implements CanonicalizableEventObject
{
    const CREATED = 'cinderella.user.created';

    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getCanonicalizableObject()
    {
        return $this->user;
    }
}
