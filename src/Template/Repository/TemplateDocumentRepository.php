<?php

namespace ScoreYa\Cinderella\Template\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\Template\Model\Template;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class TemplateDocumentRepository extends DocumentRepository implements TemplateRepository
{
    /**
     * @param string $name
     * @param Tenant $tenant
     *
     * @return Template
     */
    public function findByCanonicalName($name, Tenant $tenant)
    {
        return $this->findOneBy(['nameCanonical' => $name, 'tenant.id' => $tenant->getId()]);
    }
}
