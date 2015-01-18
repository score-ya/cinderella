<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Behat;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Exception\ExpectationException;
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SDKContext extends DefaultContext
{
    const CLIENT_SERVICE_TEMPLATE = 'score_ya.cinderella.sdk.%s_client';

    /**
     * @var MockPlugin
     */
    private $mockPlugin;
    private $clients;

    /**
     * @BeforeScenario
     */
    public function initMockPlugin()
    {
        $this->mockPlugin = new MockPlugin();
        $this->clients    = [];
    }

    /**
     * @param string       $clientName
     * @param string       $templateName
     * @param PyStringNode $templateContent
     *
     * @Given the :clientName client send a request for :templateName with:
     */
    public function theTemplateClientSendARequestForWith($clientName, $templateName, PyStringNode $templateContent)
    {
        $this->mockPlugin->addResponse(new Response(200, [], $templateContent));
        $this->getClient()->enableProfiler();

        //set to false to avoid kernel shutdown which resets the kernel and so the client with mock plugin
        $hasPerformedRequest = new \ReflectionProperty($this->getClient(), 'hasPerformedRequest');
        $hasPerformedRequest->setAccessible(true);
        $hasPerformedRequest->setValue($this->getClient(), false);

        $clientId = sprintf(self::CLIENT_SERVICE_TEMPLATE, $clientName);
        if (in_array($clientId, $this->clients) === false) {
            /** @var Client $client */
            $this->getSession()->getDriver()->reset();
            $client          = $this->container->get($clientId);
            $this->clients[] = $clientId;

            $client->addSubscriber($this->mockPlugin);
        }
    }

    /**
     * @param string       $emailAddress
     * @param PyStringNode $content
     *
     * @throws ExpectationException
     *
     * @Then I should receive an email on :emailAddress with:
     */
    public function iShouldReceiveAnEmailOnWith($emailAddress, PyStringNode $content)
    {

        $message = $this->getMessageForEmail($emailAddress);
        if (isset($message)) {
            // checking the content
            \PHPUnit_Framework_Assert::assertContains(
                $content->getRaw(),
                $message->getBody(),
                sprintf(
                    'An email has been found for "%s" but without the text "%s".',
                    $emailAddress,
                    $content->getRaw()
                )
            );

            return;

        }
        throw new ExpectationException(sprintf('No message sent to "%s"', $emailAddress), $this->getSession());


    }

    /**
     * @param string $email
     *
     * @return null|\Swift_Message
     * @throws ExpectationException
     */
    private function getMessageForEmail($email)
    {
        $client = $this->getClient();

        $profile = $client->getProfile();
        if (!$profile) {
            throw new ExpectationException(
                'Emails cannot be tested as the profiler is disabled. The profiler must be enabled.',
                $this->getSession()
            );
        }
        /** @var $collector MessageDataCollector */
        $collector = $profile->getCollector('swiftmailer');

        /** @var $message \Swift_Message */
        foreach ($collector->getMessages() as $message) {
            // Checking the recipient email and the X-Swift-To
            // header to handle the RedirectingPlugin.
            // If the recipient is not the expected one, check
            // the next mail.
            $correctRecipient = array_key_exists(
                $email,
                $message->getTo()
            );
            $headers          = $message->getHeaders();
            $correctXToHeader = false;
            if ($headers->has('X-Swift-To')) {
                $correctXToHeader = array_key_exists(
                    $email,
                    $headers->get('X-Swift-To')->getFieldBodyModel()
                );
            }

            if (!$correctRecipient && !$correctXToHeader) {
                continue;
            }

            return $message;
        }

        return null;
    }
}
