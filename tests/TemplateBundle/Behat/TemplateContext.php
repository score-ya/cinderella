<?php

namespace ScoreYa\Cinderella\Bundle\TemplateBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use ScoreYa\Cinderella\Template\Model\Template;
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
     * @param string       $name
     * @param PyStringNode $content
     *
     * @Then the template :name should contains:
     */
    public function theTemplateShouldContains($name, PyStringNode $content)
    {
        $this->getDocumentManager()->clear();
        /** @var Template $template */
        $template = $this->getDocumentManager()->getRepository(Template::class)->findOneByName($name);

        \PHPUnit_Framework_Assert::assertInstanceOf(Template::class, $template, 'Template does not exist');

        \PHPUnit_Framework_Assert::assertContains($content->getRaw(), $template->getContent());
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
