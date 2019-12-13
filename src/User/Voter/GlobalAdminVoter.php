<?php

namespace App\User\Voter;

use App\User\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * The voter allows App\User\Entity\User::ROLE_GLOBAL_ADMIN to get all the permissions
 */
class GlobalAdminVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) return false;

        return in_array(UserInterface::ROLE_GLOBAL_ADMIN, $user->getRoles());
    }
}
