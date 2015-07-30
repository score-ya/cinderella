<?php

namespace ScoreYa\Cinderella\Template\Tests\EventListener;

use ScoreYa\Cinderella\Template\Event\TemplateEvent;
use ScoreYa\Cinderella\Template\EventListener\SetApiName;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Template\EventListener\SetApiName
 */
class SetApiNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function setCorrectApiName()
    {
        $eventListener = new SetApiName();
        $event = $this->prophesize(TemplateEvent::class);
        $template = $this->prophesize(Template::class);

        $event->getTemplate()->willReturn($template->reveal());

        $template->getName()->willReturn('TEST DUMMY');

        $template->setApiName('test-dummy')->shouldBeCalled();

        call_user_func($eventListener, $event->reveal());
    }
}
