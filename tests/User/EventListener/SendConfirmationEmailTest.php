<?php

namespace ScoreYa\Cinderella\User\Tests\EventListener;

use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\User\Event\UserEvent;
use ScoreYa\Cinderella\User\EventListener\SendConfirmationEmail;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\User\EventListener\SendConfirmationEmail
 */
class SendConfirmationEmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SendConfirmationEmail
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
        $user = $this->prophesize(User::class);

        $this->hashGenerator->nextBytes(32)->willReturn('test_hash_random');

        $user->setConfirmationToken('dGVzdF9oYXNoX3JhbmRvbQ,,')->shouldBeCalled();

        $event->getUser()->willReturn($user->reveal());

        $this->listener->onUserCreated($event->reveal());
    }

    protected function setUp()
    {
        $this->hashGenerator = $this->prophesize(SecureRandomInterface::class);
        $this->listener = new SendConfirmationEmail($this->hashGenerator->reveal());
    }
}
