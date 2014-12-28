<?php

namespace ScoreYa\Cinderella\User\Repository;

use ScoreYa\Cinderella\User\Model\ApiUser;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
interface ApiUserRepository
{
    /**
     * @param string $apiKey
     *
     * @return ApiUser
     */
    public function findByApiKey($apiKey);

    /**
     * @return ApiUser[]
     */
    public function findAll();
}
