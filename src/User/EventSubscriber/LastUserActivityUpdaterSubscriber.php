<?php

namespace App\User\EventSubscriber;

use App\User\Model\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class LastUserActivityUpdaterSubscriber implements EventSubscriberInterface
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
     * This method updates User's last activity on every request
     *
     * @param RequestEvent $event
     * @throws \UnexpectedValueException
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

            $user->setLastActivity(new \DateTime());

            $this->objectManager->flush();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest'
            ]
        ];
    }
}
