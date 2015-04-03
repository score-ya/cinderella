<?php

namespace ScoreYa\Cinderella\Template\Tests\EventListener;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use ScoreYa\Cinderella\Template\EventListener\SetUserListener;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\EventListener\SetUserListener
 */
class SetUserListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function onPostDeserialize()
    {
        $event = $this->prophesize(ObjectEvent::class);
        $template = $this->prophesize(Template::class);
        $user = $this->prophesize(User::class);
        $listener = new SetUserListener($user->reveal());

        $event->getObject()->willReturn($template->reveal());

        $template->setUser($user)->shouldBeCalled();

        $listener->onPostDeserialize($event->reveal());
    }
}
