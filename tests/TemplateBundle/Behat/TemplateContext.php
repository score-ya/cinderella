<?php

namespace ScoreYa\Cinderella\Bundle\TemplateBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use ScoreYa\Cinderella\User\Model\ApiUser;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TemplateContext extends DefaultContext implements SnippetAcceptingContext
{
    /**
     * @Given I have an API Key as placeholder :placeholder
     */
    public function iHaveAnApiKeyAsPlaceholder($placeholder)
    {
        $apiUserRepository = $this->container->get('score_ya.cinderella.user.repository.api_user');

        /** @var ApiUser $apiUser */
        $apiUser = $apiUserRepository->findAll()[0];

        $this->setPlaceholder($placeholder, $apiUser->getApiKey());
    }

    /**
     * Sends a HTTP request
     *
     * @Given I send a :method request to :url with placeholder
     */
    public function iSendARequestToWithPlaceholder($method, $url)
    {
        return $this->restContext->iSendARequestTo($method, $this->replacePlaceholder($url));
    }
}
