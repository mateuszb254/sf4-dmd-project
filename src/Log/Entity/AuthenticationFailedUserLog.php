<?php

namespace App\Log\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class AuthenticationFailedUserLog extends AuthenticationUserLog
{
    public function __toString()
    {
       return 'AUTHENTICATION_FAILURE';
    }
}
