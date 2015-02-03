<?php

namespace ScoreYa\Cinderella\Template\Tests\EventListener;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\Template\EventListener\SetTenantListener;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage24.com>
 * 
 * @covers ScoreYa\Cinderella\Template\EventListener\SetTenantListener
 */
class SetTenantListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function onPostDeserialize()
    {
        $event = $this->prophesize(ObjectEvent::class);
        $template = $this->prophesize(Template::class);
        $tenant = $this->prophesize(Tenant::class);
        $listener = new SetTenantListener($tenant->reveal());

        $event->getObject()->willReturn($template->reveal());

        $template->setTenant($tenant)->shouldBeCalled();

        $listener->onPostDeserialize($event->reveal());
    }
}
