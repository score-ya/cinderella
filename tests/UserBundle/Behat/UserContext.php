<?php

namespace ScoreYa\Cinderella\Bundle\UserBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class UserContext extends DefaultContext implements SnippetAcceptingContext
{
    /**
     * @param string $name
     *
     * @throws \Exception
     * @Then the tenant :name should have an api key
     */
    public function theTenantShouldHaveAnApiKey($name)
    {
        $this->getDocumentManager()->clear();
        $tenant = $this->getDocumentManager()->getRepository(Tenant::class)->findOneByName($name);

        if ($tenant->getApiUser() === null) {
            throw new \Exception('No api key user was generated');
        }
    }
}
