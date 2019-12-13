<?php

namespace App\User\EventSubscriber;

use App\User\Event\UserEvent;
use App\User\Mailer\UserMailSenderInterface;
use App\User\Model\UserInterface;
use App\User\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class EmailChangeSubscriber implements EventSubscriberInterface
{
    /** @var UserMailSenderInterface */
    private $mailSender;

    public function __construct(UserMailSenderInterface $userMailSender)
    {
        $this->mailSender = $userMailSender;
    }

    public function sendTokenEmail(UserEvent $event)
    {
        /** @var UserInterface $user */
        $user = $event->getUser();

        $this->mailSender->sendEmailChangeTokenEmail(
            $user->getEmailChangeToken(), $user->getLogin(), $user->getEmail()
        );
    }

    public static function getSubscribedEvents()
    {
        return [
          UserEvents::USER_EMAIL_CHANGE_REQUESTED => [
              'sendTokenEmail', 64
          ]
        ];
    }
}
