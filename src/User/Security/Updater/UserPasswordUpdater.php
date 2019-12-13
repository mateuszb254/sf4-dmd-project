<?php

namespace App\User\Security\Updater;

use App\User\Model\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordUpdater implements UserPasswordUpdaterInterface
{
    /** @var UserPasswordEncoderInterface */
    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function updatePassword(UserInterface $user)
    {
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPlainPassword())
        );
    }
}
