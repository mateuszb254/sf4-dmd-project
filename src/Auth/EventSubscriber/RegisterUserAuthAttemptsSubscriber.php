<?php

namespace App\Auth\EventSubscriber;

use App\Log\Entity\AuthenticationFailedUserLog;
use App\Log\Entity\AuthenticationSuccessfulUserLog;
use App\User\Model\UserInterface;
use App\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class RegisterUserAuthAttemptsSubscriber implements EventSubscriberInterface
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var RequestStack $requestStack */
    private $requestStack;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function registerValidUserAuthentication(InteractiveLoginEvent $event)
    {
        /** @var UserInterface $user */
        $user = $event->getAuthenticationToken()->getUser();

        /** @var Request $request */
        $request = $event->getRequest();

        $authLog = (new AuthenticationSuccessfulUserLog())
            ->setUser($user)
            ->setIp($request->getClientIp())
            ->setUserAgent($request->headers->get('user-agent'));

        $this->entityManager->persist($authLog);
        $this->entityManager->flush();
    }

    public function registerInvalidUserAuthentication(AuthenticationFailureEvent $event)
    {
        /** @var TokenInterface $token */
        $token = $event->getAuthenticationToken();

        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var array $credentials */
        $credentials = $token->getCredentials();

        if (!is_array($credentials) || !array_key_exists('login', $credentials)) {
            return;
        }

        $user = $this->userRepository->findOneBy([
            'login' => $credentials['login']
        ]);

        if (!$user instanceof UserInterface) return;

        $authLog = (new AuthenticationFailedUserLog())
            ->setUser($user)
            ->setIp($request->getClientIp())
            ->setUserAgent($request->headers->get('user-agent'));

        $this->entityManager->persist($authLog);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => [
                'registerValidUserAuthentication', 0
            ],
            AuthenticationEvents::AUTHENTICATION_FAILURE => [
                'registerInvalidUserAuthentication', 0
            ]
        ];
    }
}
