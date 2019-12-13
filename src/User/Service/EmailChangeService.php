<?php

namespace App\User\Service;

use App\Core\Generator\UniquenessGeneratorInterface;
use App\User\Model\UserInterface;
use App\User\Event\UserEvent;
use App\User\UserEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmailChangeService
{
    protected $eventDispatcher;
    protected $tokenGenerator;

    public function __construct(EventDispatcherInterface $eventDispatcher, UniquenessGeneratorInterface $tokenGenerator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function handleEmailChangeRequest(UserInterface $user): void
    {
        $user->setEmailChangeToken($this->tokenGenerator->generate());
        $user->setEmailChangeTokenCreatedAt(new \DateTime());

        $this->eventDispatcher->dispatch(UserEvents::USER_EMAIL_CHANGE_REQUESTED, new UserEvent($user));
    }

    public function changeEmail(UserInterface $user, string $email)
    {
        $this->clearEmailChangeToken($user);

        $user->setEmail($email);

        $this->eventDispatcher->dispatch(UserEvents::USER_EMAIL_CHANGE_SUCCESS, new UserEvent($user));
    }

    public function handleTokenExpired(UserInterface $user): void
    {
        $this->clearEmailChangeToken($user);
    }

    protected function clearEmailChangeToken(UserInterface $user): void
    {
        $user->setEmailChangeToken(null);
        $user->setEmailChangeTokenCreatedAt(null);
    }
}
