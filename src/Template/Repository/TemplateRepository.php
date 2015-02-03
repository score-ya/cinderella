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
     * @param string $mimeType
     * @param Tenant $tenant
     *
     * @return Template
     */
    public function findForApiCall($name, $mimeType, Tenant $tenant);

    /**
     * @param Tenant $tenant
     *
     * @return Template[]
     */
    public function findAllByTenant(Tenant $tenant);

    /**
     * @param Template $template
     */
    public function delete(Template $template);

    /**
     * @param Template $template
     */
    public function update(Template $template);

    /**
     * @param Template $template
     */
    public function create(Template $template);

    /**
     * @param array $options
     *
     * @return Template[]
     */
    public function findUniqueBy(array $options);
}
