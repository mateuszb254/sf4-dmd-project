<?php

namespace App\Auth\Service;

use App\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class ManualAuthenticatorService implements ManualAuthenticatorInterface
{
    /** @var RequestStack $requestStack */
    private $requestStack;

    /** @var TokenStorageInterface $tokenStorage */
    private $tokenStorage;

    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    public function __construct(
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function authenticate(UserInterface $user): void
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $event = new InteractiveLoginEvent($this->requestStack->getCurrentRequest(), $token);
        $this->eventDispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $event);
    }
}
