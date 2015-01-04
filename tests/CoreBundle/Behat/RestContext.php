<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat;

use Behat\Mink\Exception\ExpectationException;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class RestContext extends DefaultContext
{
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
     * @Then the response should have a violation for :propertyPath
     */
    public function theResponseShouldHaveAViolationFor($propertyPath)
    {
        $json = $this->getJson();

        \PHPUnit_Framework_Assert::assertInternalType('array', $json, 'No violations are found.');

        foreach ($json as $violation) {
            if ($violation->propertyPath === $propertyPath) {
                return;
            }
        }
        throw new ExpectationException(sprintf('No violation for propertyPath "%s" found.', $propertyPath), $this->getSession());
    }

    /**
     * @Then the response should have a violation for :propertyPath with :message
     */
    public function theResponseShouldHaveAViolationForWith($propertyPath, $message)
    {
        $this->theResponseShouldHaveAViolationFor($propertyPath);

        $json = $this->getJson();

        $currentViolation = new \stdClass();

        foreach ($json as $violation) {
            if ($violation->propertyPath === $propertyPath) {
                $currentViolation = $violation;
                break;
            }
        }

        \PHPUnit_Framework_Assert::assertEquals($message, $currentViolation->message);
    }
}
