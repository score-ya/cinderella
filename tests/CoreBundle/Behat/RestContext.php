<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat;

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
}
