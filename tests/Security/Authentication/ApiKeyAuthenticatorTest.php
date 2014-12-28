<?php

namespace ScoreYa\Cinderella\Security\Tests\Authentication;

use ScoreYa\Cinderella\Security\Authentication\ApiKeyAuthenticator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Security\Authentication\ApiKeyAuthenticator
 */
class ApiKeyAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiKeyAuthenticator
     */
    private $authenticator;

    /**
     * @test
     */
    public function authenticateToken()
    {
        $token        = $this->prophesize(TokenInterface::class);
        $userProvider = $this->prophesize(UserProviderInterface::class);
        $user         = $this->prophesize(UserInterface::class);

        $user->getRoles()->willReturn([]);

        $userProvider->loadUserByUsername('api_key')->willReturn($user->reveal());

        $token->getCredentials()->willReturn('api_key');

        $this->assertInstanceOf(
            PreAuthenticatedToken::class,
            $this->authenticator->authenticateToken($token->reveal(), $userProvider->reveal(), 'provider')
        );
    }

    /**
     * @test
     */
    public function supportsToken()
    {
        $token = $this->prophesize(PreAuthenticatedToken::class);

        $token->getProviderKey()->willReturn('provider');

        $this->assertTrue($this->authenticator->supportsToken($token->reveal(), 'provider'));
        $this->assertFalse($this->authenticator->supportsToken($token->reveal(), 'other'));
        $this->assertFalse(
            $this->authenticator->supportsToken($this->prophesize(TokenInterface::class)->reveal(), 'provider')
        );
    }

    /**
     * @test
     */
    public function createNoTokenIfNoApiKeyIsFound()
    {
        $request    = $this->prophesize(Request::class);
        $query = $this->prophesize(ParameterBagInterface::class);

        $request->query = $query->reveal();

        $query->get('apikey')->willReturn(null);

        $this->assertNull($this->authenticator->createToken($request->reveal(), 'provider'));
    }

    /**
     * @test
     */
    public function createToken()
    {
        $request    = $this->prophesize(Request::class);
        $query = $this->prophesize(ParameterBagInterface::class);

        $request->query = $query->reveal();

        $query->get('apikey')->willReturn('key');

        $this->assertInstanceOf(
            PreAuthenticatedToken::class,
            $this->authenticator->createToken($request->reveal(), 'provider')
        );
    }

    protected function setUp()
    {
        $this->authenticator = new ApiKeyAuthenticator();
    }
}
