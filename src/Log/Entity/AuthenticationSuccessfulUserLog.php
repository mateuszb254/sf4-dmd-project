<?php

namespace App\Log\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class AuthenticationSuccessfulUserLog extends AuthenticationUserLog
{
    public function __toString()
    {
        return 'AUTHENTICATION_SUCCESS';
    }
}
