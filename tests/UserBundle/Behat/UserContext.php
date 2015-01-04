<?php

namespace ScoreYa\Cinderella\Bundle\UserBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use ScoreYa\Cinderella\Multitenancy\Model\Tenant;
use ScoreYa\Cinderella\User\Model\ApiUser;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class UserContext extends DefaultContext implements SnippetAcceptingContext
{
    /**
     * @param string $name
     *
     * @Then the tenant :name should have an api key
     */
    public function theTenantShouldHaveAnApiKey($name)
    {
        $this->getDocumentManager()->clear();
        $tenant = $this->getDocumentManager()->getRepository(Tenant::class)->findOneByName($name);

        \PHPUnit_Framework_Assert::assertInstanceOf(
            ApiUser::class,
            $tenant->getApiUser(),
            'No api key user was generated'
        );

        \PHPUnit_Framework_Assert::assertInternalType(
            'string',
            $tenant->getApiUser()->getApiKey(),
            'No api key was set'
        );
    }
}
