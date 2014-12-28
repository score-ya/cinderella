<?php

namespace ScoreYa\Cinderella\Bundle\SecurityBundle\Tests\Behat;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Sanpi\Behatch\Context\JsonContext;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\DefaultContext;
use ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat\RestContext;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Webmozart\Json\JsonDecoder;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SecurityContext extends DefaultContext implements SnippetAcceptingContext
{
    /**
     * @var JsonContext
     */
    private $jsonContext;

    /**
     * @var RestContext
     */
    private $scoreYaRestContext;

    /**
     * @var string
     */
    private $jwt;

    /**
     * @BeforeScenario
     */
    public function prepare(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $env */
        $env               = $scope->getEnvironment();
        $this->jsonContext = $env->getContext(JsonContext::class);
        $this->scoreYaRestContext = $env->getContext(RestContext::class);
    }

    /**
     * @Given I save the jwt
     */
    public function iSaveTheJwt()
    {
        $this->jwt = $this->getJson()->token;
    }

    /**
     * @Given I set the jwt header
     */
    public function iSetTheJwtHeader()
    {
        $this->scoreYaRestContext->iAddClientHeaderEqualTo('HTTP_AUTHORIZATION', 'Bearer '.$this->jwt);
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

    /**
     * @param $email
     * @param $password
     *
     * @return array
     *
     * @Given I log in as :email with :password
     */
    public function iLogInAs($email, $password)
    {
        $this->scoreYaRestContext->iAddClientHeaderEqualTo('CONTENT_TYPE', 'application/json');
        $this->scoreYaRestContext->iAddClientHeaderEqualTo('HTTP_ACCEPT', 'application/json');
        $this->scoreYaRestContext->iAddClientHeaderEqualTo('HTTP_AUTHORIZATION', '');
        $this->restContext->iSendARequestToWithBody('POST', '/login', new PyStringNode(['{"email": "'.$email.'","password": "'.$password.'"}'], 0));
        $this->jsonContext->theResponseShouldBeInJson();
        $this->iSaveTheJwt();
    }
}
