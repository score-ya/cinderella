<?php

namespace ScoreYa\Cinderella\Template\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class TemplateDocumentRepository extends DocumentRepository implements TemplateRepository
{
    /**
     * {@inheritdoc}
     */
    public function findForApiCall($name, $mimeType, Tenant $tenant)
    {
        return $this->findOneBy(['nameCanonical' => $name, 'mimeType' => $mimeType , 'tenant.id' => $tenant->getId()]);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByTenant(Tenant $tenant)
    {
        return $this->findBy(['tenant.id' => $tenant->getId()]);
    }
}
