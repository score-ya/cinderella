<?php

namespace ScoreYa\Cinderella\User\Event;

use ScoreYa\Cinderella\User\Model\ApiUser;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ApiUserEvent extends Event
{
    const CREATED = 'cinderella.api_user.created';

    private $apiUser;

    /**
     * @param ApiUser $apiUser
     */
    public function __construct(ApiUser $apiUser)
    {
        $this->apiUser = $apiUser;
    }

    /**
     * @return ApiUser
     */
    public function getApiUser()
    {
        return $this->apiUser;
    }
}
