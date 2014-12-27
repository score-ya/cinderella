<?php

namespace ScoreYa\Cinderella\Security\UserProvider;

use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class CanonicalizedUserProvider implements UserProviderInterface
{
    private $canonicalizer;
    private $userProvider;

    /**
     * @param Canonicalizer         $canonicalizer
     * @param UserProviderInterface $userProvider
     */
    public function __construct(Canonicalizer $canonicalizer, UserProviderInterface $userProvider)
    {
        $this->canonicalizer = $canonicalizer;
        $this->userProvider = $userProvider;
    }

    /**
     * @param string $username
     *
     * @return object|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function loadUserByUsername($username)
    {
        return $this->userProvider->loadUserByUsername($this->canonicalizer->canonicalize($username));
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->userProvider->refreshUser($user);
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $this->userProvider->supportsClass($class);
    }
}
