<?php

namespace ScoreYa\Cinderella\User\Tests\EventListener;

use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\User\Event\ApiUserEvent;
use ScoreYa\Cinderella\User\Event\UserEvent;
use ScoreYa\Cinderella\User\EventListener\GenerateApiKey;
use ScoreYa\Cinderella\User\Model\ApiUser;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\User\EventListener\GenerateApiKey
 */
class GenerateApiKeyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GenerateApiKey
     */
    private $listener;

    /**
     * @var ObjectProphecy
     */
    private $hashGenerator;

    /**
     * @test
     */
    public function onUserCreated()
    {
        $event = $this->prophesize(UserEvent::class);
        $apiUser = $this->prophesize(ApiUser::class);
        $user = $this->prophesize(User::class);

        $this->hashGenerator->nextBytes(32)->willReturn('test_hash_random');

        $apiUser->setApiKey('dGVzdF9oYXNoX3JhbmRvbQ')->shouldBeCalled();
        $apiUser->getApiKey()->willReturn(null);

        $user->getApiUser()->willReturn($apiUser->reveal());

        $event->getUser()->willReturn($user->reveal());

        $this->listener->onUserCreated($event->reveal());
    }

    /**
     * @test
     */
    public function generateNoApiKeyIfUserAlreadyHasOne()
    {
        $event = $this->prophesize(UserEvent::class);
        $apiUser = $this->prophesize(ApiUser::class);
        $user = $this->prophesize(User::class);

        $apiUser->getApiKey()->willReturn('key');

        $user->getApiUser()->willReturn($apiUser->reveal());

        $event->getUser()->willReturn($user->reveal());

        $this->listener->onUserCreated($event->reveal());
    }

    protected function setUp()
    {
        $this->hashGenerator = $this->prophesize(SecureRandomInterface::class);
        $this->listener = new GenerateApiKey($this->hashGenerator->reveal());
    }
}
