<?php

namespace App\Auth\Service;

use App\User\Model\UserInterface;

interface ManualAuthenticatorInterface
{
    public function authenticate(UserInterface $user);
}
