<?php

namespace App\User\Service;

use App\Auth\Service\ManualAuthenticatorInterface;
use App\Core\Generator\UniquenessGeneratorInterface;
use App\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ResetPasswordTokenService
{
    /** @var EventDispatcherInterface $eventDispatcher */
    protected $eventDispatcher;

    /** @var ManualAuthenticatorInterface $authenticator */
    protected $authenticator;

    /** @var UniquenessGeneratorInterface $authenticator */
    protected $tokenGenerator;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ManualAuthenticatorInterface $manualAuthenticator,
        UniquenessGeneratorInterface $tokenGenerator
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->authenticator = $manualAuthenticator;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function prepareResetPasswordToken(UserInterface $user): void
    {
        $user->setPasswordResetToken($this->tokenGenerator->generate());
        $user->setPasswordResetTokenCreatedAt(new \DateTime());
    }

    public function handleTokenExpired(UserInterface $user): void
    {
        $this->clearResetPasswordToken($user);
    }

    public function resetPassword(UserInterface $user, string $password): void
    {
        $user->setPlainPassword($password);
        $this->clearResetPasswordToken($user);

        $this->authenticator->authenticate($user);
    }

    protected function clearResetPasswordToken(UserInterface $user): void
    {
        $user->setPasswordResetToken(null);
        $user->setPasswordResetTokenCreatedAt(null);
    }
}
