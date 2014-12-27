<?php

namespace ScoreYa\Cinderella\Bundle\SecurityBundle\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
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
            [
                $beforeScenarioScope->getEnvironment()->getSuite()->getSetting('paths')['fixtures'].'/User.yml',
                $beforeScenarioScope->getEnvironment()->getSuite()->getSetting('paths')['fixtures'].'/Tenant.yml',
            ],
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
     * @Then I add :name client header equal to :value
     */
    public function iAddClientHeaderEqualTo($name, $value)
    {
        $this->getSession()->getDriver()->getClient()->setServerParameter($name, $value);
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
