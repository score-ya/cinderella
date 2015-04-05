<?php

namespace ScoreYa\Cinderella\User\Repository;

use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
interface UserRepository
{
    /**
     * @param string $token
     *
     * @return User
     */
    public function findByConfirmationToken($token);
}
