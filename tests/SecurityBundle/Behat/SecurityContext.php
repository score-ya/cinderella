<?php

namespace ScoreYa\Cinderella\Bundle\SecurityBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Element\DocumentElement;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Webmozart\Json\JsonDecoder;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SecurityContext extends DefaultContext implements SnippetAcceptingContext
{
    /**
     * @param BeforeScenarioScope $beforeScenarioScope
     *
     * @BeforeScenario
     */
    public function loadUser(BeforeScenarioScope $beforeScenarioScope)
    {
        $dm = $this->kernel->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $dm->getSchemaManager()->dropDatabases();

        $manager = $this->kernel->getContainer()->get('h4cc_alice_fixtures.manager');

        $objects = $manager->loadFiles(
            [$beforeScenarioScope->getEnvironment()->getSuite()->getSetting('paths')['fixtures'].'/User.yml'],
            'yaml'
        );

        $manager->persist($objects, true);
    }

    /**
     * Add an header element in a request
     *
     * @param string $name
     * @param string $value
     *
     * @Then I add :name header equal to :value
     */
    public function iAddHeaderEqualTo($name, $value)
    {
        $this->getSession()->getDriver()->getClient()->setServerParameter($name, $value);
    }

    /**
     * Sends a HTTP request with a body
     *
     * @param string       $method
     * @param string       $url
     * @param PyStringNode $body
     *
     * @return DocumentElement
     *
     * @Given I send a :method request to :url with body:
     */
    public function iSendARequestToWithBody($method, $url, PyStringNode $body)
    {
        /** @var Client $client */
        $client = $this->getSession()->getDriver()->getClient();
        // intercept redirection
        $client->followRedirects(false);
        $client->request(
            $method,
            $this->locatePath($url),
            array(),
            array(),
            array(),
            $body->getRaw()
        );
        $client->followRedirects(true);

        return $this->getSession()->getPage();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @throws \Exception
     * @Then the jwt should have a :field field with :value
     */
    public function theJwtShouldHaveAFieldWith($field, $value)
    {
        $jwt = $this->getJson()->token;

        $tokenParts = explode('.', $jwt);

        if (count($tokenParts) !== 3) {
            throw new \Exception(sprintf('The token "%s" is not a valid jwt token, expect was 3 parts', $jwt));
        }

        $jsonDecoder = new JsonDecoder();

        $payload = $jsonDecoder->decode(base64_decode($tokenParts[1]));

        $accessor = PropertyAccess::createPropertyAccessor();

        \PHPUnit_Framework_Assert::assertEquals($value, $accessor->getValue($payload, $field));
    }

    /**
     * @return mixed
     */
    private function getJson()
    {
        $json = $this->getSession()->getDriver()->getContent();

        $jsonDecoder = new JsonDecoder();

        return $jsonDecoder->decode($json);
    }
}
