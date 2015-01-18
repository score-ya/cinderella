<?php

namespace ScoreYa\Cinderella\User\EventListener;

use ScoreYa\Cinderella\SDK\Template\TemplateClientInterface;
use ScoreYa\Cinderella\User\Event\UserEvent;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class SendConfirmationEmail
{
    private $hashGenerator;
    private $templateClient;
    private $mailer;
    private $fromAddress;
    private $translator;

    /**
     * @param SecureRandomInterface   $hashGenerator
     * @param TemplateClientInterface $templateClient
     * @param \Swift_Mailer           $mailer
     */
    public function __construct(
        SecureRandomInterface $hashGenerator,
        TemplateClientInterface $templateClient,
        \Swift_Mailer $mailer,
        TranslatorInterface $translator,
        $fromAddress
    ) {
        $this->hashGenerator  = $hashGenerator;
        $this->templateClient = $templateClient;
        $this->mailer         = $mailer;
        $this->fromAddress    = $fromAddress;
        $this->translator = $translator;
    }

    /**
     * @param UserEvent $event
     */
    public function onUserCreated(UserEvent $event)
    {
        $user = $event->getUser();

        if ($user->isEnabled()) {
            return;
        }

        $user->setConfirmationToken(rtrim(strtr(base64_encode($this->hashGenerator->nextBytes(32)), '+/', '-_'), '='));

        $txtMailTemplate = $this->templateClient->fetch(
            'user_created',
            ['confirmation_token' => $user->getConfirmationToken()],
            'txt'
        );

        $htmlMailTemplate = $this->templateClient->fetch(
            'user_created',
            ['confirmation_token' => $user->getConfirmationToken()]
        );

        /** @var $message \Swift_Message */
        $message = $this->mailer->createMessage();
        $message
            ->addPart($txtMailTemplate, 'text/plain')
            ->setSubject($this->translator->trans('score_ya.cinderella.user.new_subject', [], 'mail'))
            ->setFrom($this->fromAddress)
            ->setTo($user->getEmail())
            ->setBody($htmlMailTemplate, 'text/html');

        $this->mailer->send($message);
    }
}
