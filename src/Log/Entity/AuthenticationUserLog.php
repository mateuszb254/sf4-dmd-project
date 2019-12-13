<?php


namespace App\Log\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AuthenticationUserLog extends UserLog
{

}
