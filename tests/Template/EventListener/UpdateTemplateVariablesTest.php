<?php

namespace ScoreYa\Cinderella\Template\Tests\EventListener;

use ScoreYa\Cinderella\Template\Event\TemplateEvent;
use ScoreYa\Cinderella\Template\EventListener\UpdateTemplateVariables;
use ScoreYa\Cinderella\Template\Loader\UpdateableLoaderInterface;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 * 
 * @covers ScoreYa\Cinderella\Template\EventListener\UpdateTemplateVariables
 */
class UpdateTemplateVariablesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function update()
    {
        $loader = $this->prophesize(UpdateableLoaderInterface::class);
        $listener = new UpdateTemplateVariables($loader->reveal());
        $event = $this->prophesize(TemplateEvent::class);
        $template = $this->prophesize(Template::class);

        $event->getTemplate()->willReturn($template->reveal());
        $loader->update($template)->shouldBeCalled();

        $listener->update($event->reveal());
    }
}
