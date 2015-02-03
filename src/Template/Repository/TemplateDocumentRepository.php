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

    /**
     * {@inheritdoc}
     */
    public function delete(Template $template)
    {
        $this->dm->remove($template);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function update(Template $template)
    {
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function create(Template $template)
    {
        $this->dm->persist($template);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findUniqueBy(array $options)
    {
        return $this->findBy(['nameCanonical' => $options['nameCanonical'], 'mimeType' => $options['mimeType'] , 'tenant.id' => $options['tenant']]);
    }
}
