<?php

namespace ScoreYa\Cinderella\User\Tests\EventListener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\SDK\Template\TemplateClientInterface;
use ScoreYa\Cinderella\User\Event\UserEvent;
use ScoreYa\Cinderella\User\EventListener\SendConfirmationEmail;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\User\EventListener\SendConfirmationEmail
 */
class SendConfirmationEmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SendConfirmationEmail
     */
    private $listener;

    /**
     * @var ObjectProphecy
     */
    private $hashGenerator;

    /**
     * @var ObjectProphecy
     */
    private $client;

    /**
     * @var ObjectProphecy
     */
    private $mailer;

    /**
     * @var ObjectProphecy
     */
    private $translator;

    /**
     * @test
     */
    public function onUserCreated()
    {
        $event = $this->prophesize(UserEvent::class);
        $user  = $this->prophesize(User::class);
        $message = $this->prophesize(\Swift_Message::class);

        $this->hashGenerator->nextBytes(32)->willReturn('test_hash_random');

        $user->getEmail()->willReturn('user-mail');
        $user->isEnabled()->willReturn(false);
        $user->setConfirmationToken(Argument::type('string'))->will(function ($args) {
            $this->getConfirmationToken()->willReturn($args[0]);
        });

        $this->client->fetch('user_created', ['confirmation_token' => 'dGVzdF9oYXNoX3JhbmRvbQ'], 'txt')
            ->willReturn('txt_template');
        $this->client->fetch('user_created', ['confirmation_token' => 'dGVzdF9oYXNoX3JhbmRvbQ'])
            ->willReturn('html_template');

        $this->translator->trans('score_ya.cinderella.user.new_subject', [], 'mail')->willReturn('subject');

        $this->mailer->send($message)->shouldBeCalled();
        $this->mailer->createMessage()->willReturn($message->reveal());

        $message->addPart('txt_template', 'text/plain')->willReturn($message);
        $message->setSubject('subject')->willReturn($message);
        $message->setFrom('no-reply')->willReturn($message);
        $message->setTo('user-mail')->willReturn($message);
        $message->setBody('html_template', 'text/html')->willReturn($message);

        $event->getUser()->willReturn($user->reveal());

        $this->listener->onUserCreated($event->reveal());
    }

    /**
     * @test
     */
    public function dontSendSendConfirmationEmailForEnabledUser()
    {
        $event = $this->prophesize(UserEvent::class);
        $user  = $this->prophesize(User::class);

        $user->isEnabled()->willReturn(true);

        $event->getUser()->willReturn($user->reveal());

        $this->listener->onUserCreated($event->reveal());
    }

    protected function setUp()
    {
        $this->hashGenerator = $this->prophesize(SecureRandomInterface::class);
        $this->client        = $this->prophesize(TemplateClientInterface::class);
        $this->mailer        = $this->prophesize(\Swift_Mailer::class);
        $this->translator    = $this->prophesize(TranslatorInterface::class);
        $this->listener      = new SendConfirmationEmail(
            $this->hashGenerator->reveal(),
            $this->client->reveal(),
            $this->mailer->reveal(),
            $this->translator->reveal(),
            'no-reply'
        );
    }
}
