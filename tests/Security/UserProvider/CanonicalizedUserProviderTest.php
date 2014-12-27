<?php

namespace ScoreYa\Cinderella\Security\Tests\UserProvider;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Security\UserProvider\CanonicalizedUserProvider;
use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Security\UserProvider\CanonicalizedUserProvider
 */
class CanonicalizedUserProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CanonicalizedUserProvider
     */
    private $canonicalizedUserProvider;

    /**
     * @var ObjectProphecy
     */
    private $canonicalizer;

    /**
     * @var ObjectProphecy
     */
    private $userProvider;

    /**
     * @test
     */
    public function loadUserByUsername()
    {
        $this->canonicalizer->canonicalize('Username')->willReturn('username');
        $this->userProvider->loadUserByUsername('username')->willReturn(
            $this->prophesize(UserInterface::class)->reveal()
        );

        $this->assertInstanceOf(UserInterface::class, $this->canonicalizedUserProvider->loadUserByUsername('Username'));
    }

    /**
     * @test
     */
    public function refreshUser()
    {
        $this->userProvider->refreshUser(Argument::type(UserInterface::class))->willReturn(
            $this->prophesize(UserInterface::class)->reveal()
        );

        $this->assertInstanceOf(
            UserInterface::class,
            $this->canonicalizedUserProvider->refreshUser($this->prophesize(UserInterface::class)->reveal())
        );
    }

    /**
     * @test
     */
    public function supportsClass()
    {
        $this->userProvider->supportsClass(Argument::type(UserInterface::class))->willReturn(true);

        $this->assertTrue(
            $this->canonicalizedUserProvider->supportsClass($this->prophesize(UserInterface::class)->reveal())
        );
    }

    protected function setUp()
    {
        $this->canonicalizer = $this->prophesize(Canonicalizer::class);
        $this->userProvider  = $this->prophesize(UserProviderInterface::class);

        $this->canonicalizedUserProvider = new CanonicalizedUserProvider(
            $this->canonicalizer->reveal(),
            $this->userProvider->reveal()
        );
    }
}
