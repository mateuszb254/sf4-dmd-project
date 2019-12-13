<?php

namespace App\User\EventSubscriber;

use App\User\Model\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class RefreshTokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
     */
    private $authorizationChecker;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    private $objectManager;

    /**
     * UserSubscriber constructor.
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function __construct(TokenStorageInterface $tokenStorage,
                                AuthorizationCheckerInterface $authorizationChecker,
                                ObjectManager $objectManager
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->objectManager = $objectManager;
    }

    /**
     * Refreshes token in order to update current user roles
     *
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) return;

        $token = $this->tokenStorage->getToken();

        if ($token && $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $token->getUser();

            if (!$user instanceof UserInterface) {
                throw new \UnexpectedValueException('The user is not an ' . UserInterface::class . ' instance');
            }

            $this->tokenStorage->setToken(new PostAuthenticationGuardToken($user, 'main', $user->getRoles()));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest', 0
            ],
        ];
    }
}
