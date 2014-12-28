<?php

namespace ScoreYa\Cinderella\Template\Repository;

use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
interface TemplateRepository
{
    /**
     * @param string $name
     * @param Tenant $tenant
     *
     * @return Template
     */
    public function findByCanonicalName($name, Tenant $tenant);
}
