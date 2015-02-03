<?php

namespace ScoreYa\Cinderella\Template\EventListener;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage24.com>
 */
class SetTenantListener
{
    private $tenant;

    /**
     * @param Tenant $tenant
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function onPostDeserialize(ObjectEvent $event)
    {
        /** @var Template $template */
        $template = $event->getObject();

        $template->setTenant($this->tenant);
    }
}
