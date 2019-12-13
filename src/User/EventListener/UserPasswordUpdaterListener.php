<?php

namespace App\User\EventListener;

use App\User\Model\UserInterface;
use App\User\Security\Updater\UserPasswordUpdaterInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class UserPasswordUpdaterListener
{
    protected $passwordUpdater;

    public function __construct(UserPasswordUpdaterInterface $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }


    public function prePersist(LifecycleEventArgs $event): void
    {
        $user = $event->getEntity();

        if (!$user instanceof UserInterface) {
            return;
        }

        $this->performUpdatingPassword($user);
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $user = $event->getEntity();

        if (!$user instanceof UserInterface) {
            return;
        }

        $this->performUpdatingPassword($user);
    }

    protected function performUpdatingPassword(UserInterface $user)
    {
        if (null === $user->getPassword() && null !== $user->getPlainPassword()) {
            $this->passwordUpdater->updatePassword($user);
        }
    }
}
