<?php

namespace ScoreYa\Cinderella\User\Tests\EventListener;

use ScoreYa\Cinderella\User\Event\UserEvent;
use ScoreYa\Cinderella\User\EventListener\SetPassword;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\User\EventListener\SetPassword
 */
class SetPasswordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function setPassword()
    {
        $encoder  = $this->prophesize(PasswordEncoderInterface::class);
        $listener = new SetPassword($encoder->reveal());
        $event    = $this->prophesize(UserEvent::class);
        $user     = $this->prophesize(User::class);

        $encoder->encodePassword('plain', null)->willReturn('encoded');

        $user->setPassword('encoded')->shouldBeCalled();
        $user->getPlainPassword()->willReturn('plain');

        $event->getUser()->willReturn($user->reveal());

        $listener->onUserCreated($event->reveal());
    }
}
