<?php

namespace ScoreYa\Cinderella\Bundle\TemplateBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\User\Model\ApiUser;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
     * @param string       $mimeType
     * @param PyStringNode $content
     *
     * @Then the template :name for :mimeType should contains:
     */
    public function theTemplateForShouldContains($name, $mimeType, PyStringNode $content)
    {
        $this->getDocumentManager()->clear();
        /** @var Template $template */
        $template = $this->container->get('score_ya.cinderella.template.repository.template')->findOneBy(
            ['name' => $name, 'mimeType' => $mimeType]
        );

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

    /**
     * @Given I have a template id as placeholder
     */
    public function iHaveATemplateIdAsPlaceholder()
    {
        $this->getDocumentManager()->clear();
        /** @var Template $template */
        $template = $this->container->get('score_ya.cinderella.template.repository.template')->findAll()[0];

        $this->setPlaceholder('TEMPLATE_ID', $template->getId());
    }

    /**
     * @When I send a :method request to :url with placeholder and body:
     */
    public function iSendARequestToWithPlaceholderAndBody($method, $url, PyStringNode $body)
    {
        $strings = $body->getStrings();

        foreach ($strings as $key => $string) {
            $strings[$key] = $this->replacePlaceholder($string);
        }

        return $this->restContext->iSendARequestToWithBody(
            $method,
            $this->replacePlaceholder($url),
            new PyStringNode($strings, $body->getLine())
        );
    }

    /**
     * @Then the template with id :id should for :property contain:
     */
    public function theTemplateWithIdShouldForContains($id, $property, PyStringNode $content)
    {
        $this->getDocumentManager()->clear();
        /** @var Template $template */
        $template = $this->container->get('score_ya.cinderella.template.repository.template')->findOneBy(
            ['id' => $this->replacePlaceholder($id)]
        );

        $accessor = PropertyAccess::createPropertyAccessor();

        \PHPUnit_Framework_Assert::assertInstanceOf(Template::class, $template, 'Template does not exist');

        \PHPUnit_Framework_Assert::assertContains($accessor->getValue($template, $property), $content->getRaw());
    }
}
