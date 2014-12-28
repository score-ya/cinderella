<?php

namespace ScoreYa\Cinderella\User\Tests\EventListener;

use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\User\Event\ApiUserEvent;
use ScoreYa\Cinderella\User\EventListener\GenerateApiKey;
use ScoreYa\Cinderella\User\Model\ApiUser;
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
        $event = $this->prophesize(ApiUserEvent::class);
        $apiUser = $this->prophesize(ApiUser::class);

        $this->hashGenerator->nextBytes(32)->willReturn('test_hash_random');

        $apiUser->setApiKey('dGVzdF9oYXNoX3JhbmRvbQ')->shouldBeCalled();

        $event->getApiUser()->willReturn($apiUser->reveal());

        $this->listener->onApiUserCreated($event->reveal());
    }

    protected function setUp()
    {
        $this->hashGenerator = $this->prophesize(SecureRandomInterface::class);
        $this->listener = new GenerateApiKey($this->hashGenerator->reveal());
    }
}
