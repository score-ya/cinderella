<?php

namespace ScoreYa\Cinderella\Security\Tests\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use ScoreYa\Cinderella\Security\EventListener\AddApiToken;
use ScoreYa\Cinderella\User\Model\ApiUser;
use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Security\EventListener\AddApiToken
 */
class AddApiTokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AddApiToken
     */
    private $tokenAdder;

    /**
     * @test
     */
    public function doNothingIfNoneValidUser()
    {
        $event = $this->prophesize(AuthenticationSuccessEvent::class);

        $event->getUser()->willReturn(new \stdClass());
        $event->getData()->willReturn([]);

        $this->tokenAdder->onAuthenticationSuccess($event->reveal());
    }

    /**
     * @test
     */
    public function addApiToken()
    {
        $event = $this->prophesize(AuthenticationSuccessEvent::class);
        $user = $this->prophesize(User::class);
        $apiUser = $this->prophesize(ApiUser::class);

        $event->getUser()->willReturn($user->reveal());
        $event->getData()->willReturn([]);
        $event->setData(['data' => ['apiKey' => 'key']])->shouldBeCalled();

        $user->getApiUser()->willReturn($apiUser->reveal());

        $apiUser->getApiKey()->willReturn('key');

        $this->tokenAdder->onAuthenticationSuccess($event->reveal());
    }


    protected function setUp()
    {
        $this->tokenAdder = new AddApiToken();
    }
}
