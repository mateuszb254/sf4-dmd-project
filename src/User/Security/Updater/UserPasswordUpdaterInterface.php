<?php

namespace App\User\Security\Updater;

use App\User\Model\UserInterface;

interface UserPasswordUpdaterInterface
{
    public function updatePassword(UserInterface $user);
}
