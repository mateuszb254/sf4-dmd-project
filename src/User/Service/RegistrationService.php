<?php

namespace App\User\Service;

use App\Auth\Service\ManualAuthenticatorInterface;
use App\User\Event\UserEvent;
use App\User\Model\UserInterface;
use App\User\UserEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class RegistrationService
{
    /** @var EventDispatcherInterface $eventDispatcher */
    protected $eventDispatcher;

    /** @var EventDispatcherInterface $entityManager */
    protected $entityManager;

    /** @var ManualAuthenticatorInterface $authenticator */
    protected $authenticator;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EntityManagerInterface $entityManager,
        ManualAuthenticatorInterface $manualAuthenticator
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
        $this->authenticator = $manualAuthenticator;
    }

    public function register(UserInterface $user): void
    {
        $this->entityManager->persist($user);

        $this->eventDispatcher->dispatch(UserEvents::USER_CREATED, new UserEvent($user));

        $this->entityManager->flush();

        $this->authenticator->authenticate($user);
    }
}
