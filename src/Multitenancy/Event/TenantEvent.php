<?php

namespace ScoreYa\Cinderella\Multitenancy\Event;

use ScoreYa\Cinderella\Core\Event\CanonicalizableEventObject;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class TenantEvent extends Event implements CanonicalizableEventObject
{
    const CREATED = 'cinderella.tenant.created';

    private $tenant;

    /**
     * @param Tenant $tenant
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * @return mixed
     */
    public function getCanonicalizableObject()
    {
        return $this->tenant;
    }
}
